<?php
/**
 * Created by PHPStorm
 * User: ccl
 * Date: 2019/08/23
 * Time: 19:52
 */
namespace BinaryProtocol\Protocol\Pet;
use BinaryStream\BinaryReader;
use BinaryStream\BinaryWriter;
use BinaryProtocol\BaseMessage;
/**
 * function pet entity
 */
class Pet extends BaseMessage
{
    /**
     * template id
     * @var int $modelId
     */
    public $modelId;
    /**
     * pet instance id
     * @var string $instanceId
     */
    public $instanceId;
    /**
     * pet level
     * @var int $petLv
     */
    public $petLv;
    /**
     * pet status
     * @var int $petState
     */
    public $petState;
    /**
     * pet experience
     * @var string $petExp
     */
    public $petExp;
    /**
     * pet quality
     * @var int $petQuality
     */
    public $petQuality;
    /**
     * intimacy level
     * @var int $intimacyLv
     */
    public $intimacyLv;
    /** 
     * pet personal property list
     * @var array $personValue 
     */
    public $personValue;
    /** 
     * pet effort property list
     * @var array $effortValue 
     */
    public $effortValue;
    /** 
     * act skill array
     * @var array $activeSkills 
     */
    public $activeSkills;
    /** 
     * pet property list
     * @var array $propertys 
     */
    public $propertys;
    public function __construct()
    {
        parent::__construct();
        $this->modelId = 0;
        $this->instanceId = '';
        $this->petLv = 0;
        $this->petState = 0;
        $this->petExp = '';
        $this->petQuality = 0;
        $this->intimacyLv = 0;
        $this->personValue = [];
        $this->effortValue = [];
        $this->activeSkills = [];
        $this->propertys = [];
    }
    /**
     * write buffer data
     * @throws
     * @param BinaryWriter $buffer
     * @return string
     */
    public function write(BinaryWriter $buffer)
    {
        // TODO: Implement write() method.
        $buffer->writeInt32($this->modelId);
        $buffer->writeUTFString($this->instanceId);
        $buffer->writeInt32($this->petLv);
        $buffer->writeInt32($this->petState);
        $buffer->writeUTFString($this->petExp);
        $buffer->writeInt32($this->petQuality);
        $buffer->writeInt32($this->intimacyLv);
        $buffer->writeShort(count($this->personValue));
        for($i = 0; $i < count($this->personValue); $i++){
            $this->personValue[$i]->write($buffer);
        }
        $buffer->writeShort(count($this->effortValue));
        for($i = 0; $i < count($this->effortValue); $i++){
            $this->effortValue[$i]->write($buffer);
        }
        $buffer->writeShort(count($this->activeSkills));
        for($i = 0; $i < count($this->activeSkills); $i++){
            $buffer->writeInt32($this->activeSkills[$i]);
        }
        $buffer->writeShort(count($this->propertys));
        for($i = 0; $i < count($this->propertys); $i++){
            $this->propertys[$i]->write($buffer);
        }
        return $buffer->getWriteStream();
    }
    /**
     * read buffer data
     * @param BinaryReader $buffer
     */
    public function read(BinaryReader $buffer)
    {
        // TODO: Implement read() method.
        $this->modelId = $buffer->readInt32();
        $this->instanceId = $buffer->readUTFString();
        $this->petLv = $buffer->readInt32();
        $this->petState = $buffer->readInt32();
        $this->petExp = $buffer->readUTFString();
        $this->petQuality = $buffer->readInt32();
        $this->intimacyLv = $buffer->readInt32();
        $personValue_len = $buffer->readShort();
        for($i = 0; $i < $personValue_len; $i++){
            $value = new PetProperty();
            $value->read($buffer);
            $this->personValue[$i] = $value;
        }
        $effortValue_len = $buffer->readShort();
        for($i = 0; $i < $effortValue_len; $i++){
            $value = new PetProperty();
            $value->read($buffer);
            $this->effortValue[$i] = $value;
        }
        $activeSkills_len = $buffer->readShort();
        for($i = 0; $i < $activeSkills_len; $i++){
            $value = $buffer->readInt32();
            $this->activeSkills[$i] = $value;
        }
        $propertys_len = $buffer->readShort();
        for($i = 0; $i < $propertys_len; $i++){
            $value = new PetProperty();
            $value->read($buffer);
            $this->propertys[$i] = $value;
        }
    }
}