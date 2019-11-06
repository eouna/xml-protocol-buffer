<?php

return "<?php
namespace {:name_space};
use \RuntimeException;
class MsgFactory
{

{:const_defines}

    /**
     * class instance map
     * @var array \$class_map
     * */
    private static \$class_map = [
{:class_map}
    ];
    
    /**
     * message id index 
     * */
    private static \$message_map = [
{:message_map}
    ];
    
    /**
     * get message class instance by message id
     * @param string \$msg_id
     * @return BaseMessage
     * */
    public static function getInstance(string \$msg_id){
        
        if(isset(self::\$message_map[\$msg_id]))
            return new self::\$class_map[\$msg_id];
        if(isset(self::\$class_map[\$msg_id]))
            return new self::\$class_map[\$msg_id];
        
        throw new RuntimeException('MESSAGE DATA NOT FOUND!');
    }
}";