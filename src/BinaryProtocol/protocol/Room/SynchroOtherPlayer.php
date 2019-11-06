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
 * function 同步其他玩家
 */
class SynchroOtherPlayer extends BaseMessage
{
    const MSG_ID = 10002;
    /** 
     * 玩家信息
     * @var array $OtherPlayer 
     */
    public $OtherPlayer;
    public function __construct()
    {
        parent::__construct();
        $this->OtherPlayer = [];
    }
    /**
     * return message ID
     * @return int
     */
    public static function getMsgID(){
        return 10002;
    }
    /**
     * return message ID
     * @return int
     */
    public static function msgID(){
        return 10002;
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
        $buffer->writeShort(count($this->OtherPlayer));
        for($i = 0; $i < count($this->OtherPlayer); $i++){
            $this->OtherPlayer[$i]->write($buffer);
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
        $OtherPlayer_len = $buffer->readShort();
        for($i = 0; $i < $OtherPlayer_len; $i++){
            $value = new PlayerInfo();
            $value->read($buffer);
            $this->OtherPlayer[$i] = $value;
        }
    }
}