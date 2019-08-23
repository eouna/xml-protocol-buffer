<?php
/**
 * Created by PhpStorm.
 * User: ccl
 * Date: 2019/8/20
 * Time: 17:50
 */

class protocolGenerator
{

    const STRUCT = 1;
    const MESSAGE = 2;

    private $_ATTR = "@attributes";

    private $_config;

    /**
     * template string
     * */
    private $_template_string;

    /**
     * self define options
     * @param  array $options
     * */
    public function __construct($options = [])
    {

        $this->_template_string = include __DIR__ . "/template/template.php";
        $this->_config = include __DIR__ . "/../../config.php";

        $this->baseMessageGenerator();
        $this->autoLoadGenerator();

        foreach ($options as $key => $value)
            if(isset($this->_config[$key]))
                $this->_config = $value;
    }

    /**
     * code description message
     * */
    private function getCodeDescription(){
        return '/**
 * Created by ' . $this->_config['generator'] . '
 * User: ' . $this->_config['author'] . '
 * Date: '. date("Y/m/d") . '
 * Time: '. date("H:s") . '
 */';
    }

    /**
     * generate message id code block
     * @param int $msg_id
     * @param bool $flag
     * @return string
     * */
    private function getMsgCodeBlock(int $msg_id, $flag = true){
        $description = '    /**
     * return message ID
     * @return int
     */
';
        return  $description .( $flag ? '    function getMsgID(){
        return ' . $msg_id. ';
    }
' : '    function msgID(){
        return ' . $msg_id . ';
    }
');
    }

    /**
     * get file path info
     * @param string $path scanner path
     * @return array | bool
     * */
    private function getFileInfo($path){

        if (!is_dir($path)) return false;

        $files = scandir($path);
        $file_info = [];

        foreach ($files as $file_name) {
            if ($file_name == '.' || $file_name == '..') continue;
            $path_info = pathinfo($file_name);
            if(!isset($path_info['extension']) || $path_info['extension'] != 'xml') continue;
            $file_info[] = $file_name;
        }

        return $file_info;
    }

    /**
     * parse xml data
     * */
    public function parseXML(){

        $base_path = $this->getDirectoryPath("xml_config_directory");
        if(!is_dir($base_path))
            mkdir($base_path, 655, true);

        $files_path = self::getFileInfo($base_path);
        if(empty($files_path))
            throw new RuntimeException("In This Folder：{$base_path} Not Found Xml Config Files");

        foreach ($files_path as $key => $name){

            $xml_file = file_get_contents($base_path . $name);
            var_dump($base_path . $name);
            $xml_string = simplexml_load_string($xml_file);

            if(!$xml_string) continue;

            $json_data = json_decode(json_encode($xml_string), true);
            $namespace = '';
            foreach ($json_data as $xml_type => $value){
                if($xml_type == 'comment' && ((isset($value[0]) && empty($value[0])) || empty($value)))
                    continue 1;

                if($xml_type == $this->_ATTR)
                    $namespace = $value['namespace'] ?? "";
                self::xmlKeyDispatch($namespace, $xml_type, $value);
            }
        }
    }

    /**
     * generate autoloader code block
     * */
    public function autoLoadGenerator(){
        $config_loader = '<?php
'. $this->getCodeDescription() .'
 
function classLoader($class){
    $path = str_replace(\'\\\\\', DIRECTORY_SEPARATOR, $class);
    $file = __DIR__ . \'/src/\' . $path . \'.php\';
    if (file_exists($file))
        require_once $file;
}

spl_autoload_register(\'classLoader\');
';
        return file_put_contents($this->getFilePath('autoloader_location'), $config_loader);
    }

    /**
     * generate base message class
     * */
    public function baseMessageGenerator(){
        $config_loader = '<?php
'. $this->getCodeDescription() .'

namespace BinaryProtocol;

use BinaryStream\BinaryReader;
use BinaryStream\BinaryWriter;

abstract class BaseMessage
{
    public function __construct()
    {
    }

    /**
     * write buffer data
     * @param BinaryWriter $buffer
     * @return string
     */
    abstract public function write(BinaryWriter $buffer);

    /**
     * read buffer data
     * @param BinaryReader $buffer
     */
    abstract public function read(BinaryReader $buffer);
    
    /**
     * try to access none attribute throw configure table exception 
     * @param mixed $name
     * */
    public function __isset(string $name)
    {
        // TODO: Implement __isset() method.
        throw new \RuntimeException("·This Attribute：{$name} Not Found In Configure·");
    }
}
';
        return file_put_contents($this->getFilePath('base_message_location'), $config_loader);
    }

    /**
     * get configure file path
     * @param string $file_name
     * @return mixed
     * */
    public function getFilePath(string $file_name){

        $file_path = isset($this->_config['file'][$file_name])
            ? __DIR__ . $this->_config['file'][$file_name]['name']
            : __DIR__ . $this->_config['file']['default_location']['name'] . $file_name;

        if(!is_dir(dirname($file_path)))
            mkdir(dirname($file_path), 655, true);

        return $file_path;
    }

    /**
     * get configure directory path
     * @param string $file_name
     * @return mixed
     * */
    public function getDirectoryPath(string $file_name){
        return isset($this->_config['directory'][$file_name])
            ? __DIR__ . $this->_config['directory'][$file_name]['name']
            : __DIR__ . $this->_config['directory']['default_location']['name'] . $file_name;
    }

    /**
     * dispatch code block by xml key
     * @param string $namespace
     * @param string $field_name
     * @param $protocol_data
     * @return mixed
     * */
    protected function xmlKeyDispatch(string $namespace, string $field_name, $protocol_data){

        if(!empty($protocol_data) && is_array($protocol_data)){
            switch ($field_name){
                case $this->_config['alias_list']['message']:
                    $protocol_info = [];
                    if(is_array($protocol_data) && !isset($protocol_data[$this->_ATTR])){
                        foreach ($protocol_data as $value)
                            $protocol_info[] = $this->dealMessage($value);
                    }else
                        $protocol_info[] = $this->dealMessage($protocol_data);
                    self::codeFactory($namespace, self::MESSAGE, $protocol_info);
                    break;
                case $this->_config['alias_list']['field']:
                    if(!is_array($protocol_data))
                        return null;
                    return $this->dealFiled($protocol_data);
                case $this->_config['alias_list']['list']:
                    if(!is_array($protocol_data))
                        return null;
                    return $this->dealList($protocol_data);
                case $this->_config['alias_list']['struct']:
                    $protocol_info = [];
                    if(is_array($protocol_data) && !isset($protocol_data[$this->_ATTR])){
                        foreach ($protocol_data as $value)
                            $protocol_info[] = $this->dealStruct($value);
                    }else
                        $protocol_info[] = $this->dealStruct($protocol_data);
                    self::codeFactory($namespace, self::STRUCT, $protocol_info);
                    break;
                default:
                    return false;
            }
        }
    }

    /**
     * deal struct type
     * @param $protocol_info
     * @return mixed
     * */
    public function dealStruct(array $protocol_info){

        $class_name = $class_function = $attribute = '';
        $list = $field = [];

        foreach ($protocol_info as $key => $value){
            switch ($key){
                case $this->_ATTR:
                    $class_name = $value[$this->_config['alias_list']['name']];
                    $class_function = $value[$this->_config['alias_list']['explain']];
                    break;
                case $this->_config['alias_list']['field']:
                    $field = $this->dealFiled($value);
                    break;
                case $this->_config['alias_list']['list']:
                    if(is_array($value) && !isset($value[$this->_ATTR])){
                        foreach ($value as $key_name => $list_data)
                            $list[] = $this->dealList($list_data);
                    }else
                        $list[] = $this->dealList($value);
                    break;
            }
        }

        return [
            'class_name' => $class_name,
            'class_function' => $class_function,
            'field' => $field,
            'list' => $list,
        ];
    }

    /**
     * deal message type
     * @param $protocol_info
     * @return array
     * */
    public function dealMessage(array $protocol_info){

        $list = $field = [];
        $class_name = $class_function = $attribute = '';
        $msg_id = 0;

        foreach ($protocol_info as $key => $value){

            if(!is_array($value)) continue 1;
            switch ($key){
                case $this->_ATTR:
                    $msg_id = $value[$this->_config['alias_list']['msg_id']];
                    $class_name = $value[$this->_config['alias_list']['name']];
                    $class_function = $value[$this->_config['alias_list']['explain']];
                    break;
                case $this->_config['alias_list']['field']:
                    empty($value) ?: $field = $this->dealFiled($value);
                    break;
                case $this->_config['alias_list']['list']:
                    if(is_array($value) && !isset($value[$this->_ATTR])){
                        foreach ($value as $key_name => $list_data)
                            $list[] = $this->dealList($list_data);
                    }else
                        $list[] = $this->dealList($value);
                    break;
            }
        }
        return [
            'class_name' => $class_name,
            'class_function' => $class_function,
            'field' => $field,
            'list' => $list,
            'msg_id' => $msg_id,
        ];
    }

    /**
     * deal list type
     * @param $protocol_info
     * @return mixed
     * */
    public function dealList(array $protocol_info){

        $list = [];
        $list['read_string'] = "";
        $list['write_string'] = "";
        $list["_string"] = $list["construct_string"] = '';

        foreach ($protocol_info as $value) {

            $attr_name = $value[$this->_config['alias_list']['name']];
            $attr_class = $value[$this->_config['alias_list']['class']];

            $list["_string"] .= "    /** 
     * {$value[$this->_config['alias_list']['explain']]}
     * @var array \${$attr_name} 
     */
    public \${$attr_name};
";
            $list["construct_string"] .= "        \$this->{$attr_name} = [];
";
            $read_replace = (isset($this->_config['class_type'][$attr_class]) ?
            "\$value = \$buffer->{$this->_config['buffer_alias']['r_'.$attr_class]}();
            \$this->{$attr_name}[\$i] = \$value;" : "\$value = new {$attr_class}();
            \$value->read(\$buffer);
            \$this->{$attr_name}[\$i] = \$value;");

            $write_replace = (isset($this->_config['class_type'][$attr_class]) ?
            "\$buffer->{$this->_config['buffer_alias']['w_'.$attr_class]}(\$this->{$attr_name}[\$i]);"
                : "\$this->{$attr_name}[\$i]->write(\$buffer);");

            $list['write_string'] .= "        \$buffer->writeShort(count(\$this->{$attr_name}));
        for(\$i = 0; \$i < count(\$this->{$attr_name}); \$i++){
            " . $write_replace . "
        }
";
            $list['read_string'] .= "        \${$attr_name}_len = \$buffer->readShort();
        for(\$i = 0; \$i < \${$attr_name}_len; \$i++){
            " . $read_replace . "
        }
";
            $list["attribute_list"][] = $this->_config['alias_list']['name'];
        }
        return $list;
    }

    /**
     * deal field type
     * @param $protocol_info
     * @return array
     * */
    public function dealFiled(array $protocol_info){

        $attribute = [];
        $attribute['read_string'] = "";
        $attribute['write_string'] = "";
        $attribute["_string"] = '';
        $attribute['construct_string'] = '';

        foreach ($protocol_info as $value) {

            isset($value[$this->_ATTR]) ?: $value[$this->_ATTR] = $value;
            $attr_name = $value[$this->_ATTR][$this->_config['alias_list']['name']];
            $attr_class = $value[$this->_ATTR][$this->_config['alias_list']['class']];
            $attr_explain = $value[$this->_ATTR][$this->_config['alias_list']['explain']];

            $attribute["_string"] .= "    /**
     * {$attr_explain}
     * @var {$attr_class} \${$attr_name}
     */
    public \${$attr_name};
";
            $default_class = isset($this->_config['type_default_value'][$attr_class]) ? $this->_config['type_default_value'][$attr_class] : 'new ' . $attr_class . '()';
            $attribute['construct_string'] .= "        \$this->{$attr_name} = {$default_class};
";
            $attribute["attribute_list"][] = $this->_config['alias_list']['name'];
            if(isset($this->_config['buffer_alias']['w_' . $attr_class])){
                $attribute['write_string'] .= "        \$buffer->{$this->_config['buffer_alias']['w_' . $attr_class]}(\$this->{$attr_name});
";
                $attribute['read_string'] .= "        \$this->{$attr_name} = \$buffer->{$this->_config['buffer_alias']['r_' . $attr_class]}();
";
            }else{
                $attribute['write_string'] .= "        \$this->{$attr_name} = new {$attr_class}();
        \$this->{$attr_name}->write(\$buffer);
";
                $attribute['read_string'] .= "        \$this->{$attr_name} = new {$attr_class}();
        \$this->{$attr_name}->read(\$buffer);
";
            }
        }

        return $attribute;
    }

    /**
     * compact all code block to file
     * @param string $namespace
     * @param int $type
     * @param array $data
     * */
    private function codeFactory(string $namespace, int $type = self::MESSAGE, array $data = []){

        foreach ($data as $key => $protocol_data){

            $code_template = $this->_template_string;
            $code_template = str_replace($this->_config['template_anchor']['description'], $this->getCodeDescription(), $code_template);
            $code_template = str_replace($this->_config['template_anchor']['namespace'], $namespace, $code_template);
            $code_template = str_replace($this->_config['template_anchor']['class_function'], $protocol_data['class_function'], $code_template);
            $code_template = str_replace($this->_config['template_anchor']['class_name'], $protocol_data['class_name'], $code_template);

            if($type == self::MESSAGE){
                $code_template = str_replace($this->_config['template_anchor']['getMsgId'], $this->getMsgCodeBlock($protocol_data['msg_id']), $code_template);
                $code_template = str_replace($this->_config['template_anchor']['MsgId'], $this->getMsgCodeBlock($protocol_data['msg_id'], false), $code_template);
            } else{
                $code_template = str_replace($this->_config['template_anchor']['getMsgId'], '', $code_template);
                $code_template = str_replace($this->_config['template_anchor']['MsgId'], '', $code_template);
            }

            $list_attribute_string = $construct = $write_string = $read_string = '';
            if(!empty($protocol_data['list']))
                foreach ($protocol_data['list'] as $list_data){
                    $list_attribute_string .= $list_data['_string'];
                    $construct .= $list_data['construct_string'];
                    $write_string .= $list_data['write_string'];
                    $read_string .= $list_data['read_string'];
                }

            $attribute_string = ($protocol_data['field']['_string'] ?? "") . $list_attribute_string;
            $construct_string = ($protocol_data['field']['construct_string'] ?? "") . $construct;
            $write_string = ($protocol_data['field']['write_string'] ?? "") . $write_string . "        return \$buffer->getWriteStream();
";
            $code_template = str_replace($this->_config['template_anchor']['attribute'], $attribute_string, $code_template);
            $code_template = str_replace($this->_config['template_anchor']['construct_init'], $construct_string, $code_template);
            $code_template = str_replace($this->_config['template_anchor']['write_block'], $write_string, $code_template);
            $code_template = str_replace($this->_config['template_anchor']['read_block'], ($protocol_data['field']['read_string'] ?? "") . $read_string, $code_template);

            $place_string = $this->getDirectoryPath('protocol_directory') . '/' . $namespace;
            if(!is_dir($place_string))
                mkdir($place_string, 655, true);

            $code_template = preg_replace('/\n[\s| ]*\r/', '', $code_template);
            file_put_contents($place_string . "/{$protocol_data['class_name']}.php", $code_template);
        }
    }
}