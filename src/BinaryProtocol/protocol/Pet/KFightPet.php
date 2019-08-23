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
 * function pet chip
 */
class KFightPet extends BaseMessage
{
    /**
     * pet id
     * @var int $pid
     */
    public $pid;
    /**
     * fight idx
     * @var int $fightIdx
     */
    public $fightIdx;
    public function __construct()
    {
        parent::__construct();
        $this->pid = 0;
        $this->fightIdx = 0;
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
        $buffer->writeInt32($this->pid);
        $buffer->writeInt32($this->fightIdx);
        return $buffer->getWriteStream();
    }
    /**
     * read buffer data
     * @param BinaryReader $buffer
     */
    public function read(BinaryReader $buffer)
    {
        // TODO: Implement read() method.
        $this->pid = $buffer->readInt32();
        $this->fightIdx = $buffer->readInt32();
    }
}