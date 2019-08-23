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
 * function this message is empty data to send
 */
class ReqNoReturn extends BaseMessage
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * return message ID
     * @return int
     */
    function getMsgID(){
        return 100003;
    }
    /**
     * return message ID
     * @return int
     */
    function msgID(){
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