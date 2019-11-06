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
 * function this message is empty data to send
 */
class ReqNoReturn extends BaseMessage
{
    const MSG_ID = 100003;
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * return message ID
     * @return int
     */
    public static function getMsgID(){
        return 100003;
    }
    /**
     * return message ID
     * @return int
     */
    public static function msgID(){
        return 100003;
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
        return $buffer->getWriteStream();
    }
    /**
     * read buffer data
     * @param BinaryReader $buffer
     */
    public function read(BinaryReader $buffer)
    {
        // TODO: Implement read() method.
    }
}