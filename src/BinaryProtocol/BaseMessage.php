<?php
/**
 * Created by PHPStorm
 * User: ccl
 * Date: 2019/08/23
 * Time: 19:52
 */

namespace BinaryProtocol;

use BinaryStream\BinaryReader;
use BinaryStream\BinaryWriter;

abstract class BaseMessage
{
    public function __construct()
    {
    }

    /**
     * write buffer data
     * @param BinaryWriter $buffer
     * @return string
     */
    abstract public function write(BinaryWriter $buffer);

    /**
     * read buffer data
     * @param BinaryReader $buffer
     */
    abstract public function read(BinaryReader $buffer);
    
    /**
     * try to access none attribute throw configure table exception 
     * @param mixed $name
     * */
    public function __isset(string $name)
    {
        // TODO: Implement __isset() method.
        throw new \RuntimeException("·This Attribute：{$name} Not Found In Configure·");
    }
}
