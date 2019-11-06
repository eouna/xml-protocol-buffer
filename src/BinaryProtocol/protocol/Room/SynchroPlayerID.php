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
 * function 同步玩家专属ID
 */
class SynchroPlayerID extends BaseMessage
{
    const MSG_ID = 10000;
    /**
     * 家专属ID
     * @var string $PlayerID
     */
    public $PlayerID;
    public function __construct()
    {
        parent::__construct();
        $this->PlayerID = '';
    }
    /**
     * return message ID
     * @return int
     */
    public static function getMsgID(){
        return 10000;
    }
    /**
     * return message ID
     * @return int
     */
    public static function msgID(){
        return 10000;
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
    }
}