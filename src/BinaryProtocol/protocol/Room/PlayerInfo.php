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
use BinaryProtocol\BaseStruct;
/**
 * function 玩家信息结构体
 */
class PlayerInfo extends BaseStruct
{
    /**
     * 玩家ID
     * @var string $PlayerID
     */
    public $PlayerID;
    /**
     * 玩家坐标X
     * @var int $x
     */
    public $x;
    /**
     * 玩家坐标Y
     * @var int $y
     */
    public $y;
    public function __construct()
    {
        parent::__construct();
        $this->PlayerID = '';
        $this->x = 0;
        $this->y = 0;
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
        $buffer->writeInt32($this->x);
        $buffer->writeInt32($this->y);
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
        $this->x = $buffer->readInt32();
        $this->y = $buffer->readInt32();
    }
}