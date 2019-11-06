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
use BinaryProtocol\BaseStruct;
/**
 * function property
 */
class PetProperty extends BaseStruct
{
    /**
     * property id
     * @var int $pid
     */
    public $pid;
    /**
     * property
     * @var int $pvalue
     */
    public $pvalue;
    public function __construct()
    {
        parent::__construct();
        $this->pid = 0;
        $this->pvalue = 0;
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
        $buffer->writeInt32($this->pvalue);
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
        $this->pvalue = $buffer->readInt32();
    }
}