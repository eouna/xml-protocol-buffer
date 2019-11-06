<?php
/**
 * Created by PHPStorm
 * User: ccl
 * Date: 2019/11/06
 * Time: 18:03
 */
namespace BinaryProtocol\Protocol\Room;
use BinaryStream\BinaryReader;
use BinaryStream\BinaryWriter;
use BinaryProtocol\BaseMessage;
/**
 * function 请求进入房间
 */
class AskEnterRoom extends BaseMessage
{
    const MSG_ID = 10001;
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * return message ID
     * @return int
     */
    public static function getMsgID(){
        return 10001;
    }
    /**
     * return message ID
     * @return int
     */
    public static function msgID(){
        return 10001;
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