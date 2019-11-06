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
 * function 返回进入房间信息
 */
class ResponseEnterRoom extends BaseMessage
{
    const MSG_ID = 100010;
    /**
     * 玩家id
     * @var string $PlayerID
     */
    public $PlayerID;
    /**
     * 房间id
     * @var string $RoomID
     */
    public $RoomID;
    public function __construct()
    {
        parent::__construct();
        $this->PlayerID = '';
        $this->RoomID = '';
    }
    /**
     * return message ID
     * @return int
     */
    public static function getMsgID(){
        return 100010;
    }
    /**
     * return message ID
     * @return int
     */
    public static function msgID(){
        return 100010;
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
        $buffer->writeUTFString($this->PlayerID);
        $buffer->writeUTFString($this->RoomID);
        return $buffer->getWriteStream();
    }
    /**
     * read buffer data
     * @param BinaryReader $buffer
     */
    public function read(BinaryReader $buffer)
    {
        // TODO: Implement read() method.
        $this->PlayerID = $buffer->readUTFString();
        $this->RoomID = $buffer->readUTFString();
    }
}