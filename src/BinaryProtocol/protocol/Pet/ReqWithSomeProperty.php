<?php
/**
 * Created by PHPStorm
 * User: ccl
 * Date: 2019/11/06
 * Time: 18:03
 */
namespace BinaryProtocol\Protocol\Pet;
use BinaryStream\BinaryReader;
use BinaryStream\BinaryWriter;
use BinaryProtocol\BaseMessage;
/**
 * function some explain
 */
class ReqWithSomeProperty extends BaseMessage
{
    const MSG_ID = 100002;
    /**
     * pet instance id
     * @var string $petId
     */
    public $petId;
    /** 
     * pet property ids: array
     * @var array $propertyIds 
     */
    public $propertyIds;
    public function __construct()
    {
        parent::__construct();
        $this->petId = '';
        $this->propertyIds = [];
    }
    /**
     * return message ID
     * @return int
     */
    public static function getMsgID(){
        return 100002;
    }
    /**
     * return message ID
     * @return int
     */
    public static function msgID(){
        return 100002;
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
        $buffer->writeUTFString($this->petId);
        $buffer->writeShort(count($this->propertyIds));
        for($i = 0; $i < count($this->propertyIds); $i++){
            $buffer->writeInt32($this->propertyIds[$i]);
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
        $this->petId = $buffer->readUTFString();
        $propertyIds_len = $buffer->readShort();
        for($i = 0; $i < $propertyIds_len; $i++){
            $value = $buffer->readInt32();
            $this->propertyIds[$i] = $value;
        }
    }
}