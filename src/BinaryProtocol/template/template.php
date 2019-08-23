<?php

return '<?php
{:description}

namespace BinaryProtocol\Protocol\{:name_space};

use BinaryStream\BinaryReader;
use BinaryStream\BinaryWriter;
use BinaryProtocol\BaseMessage;

/**
 * function {:class_function}
 */
class {:class_name} extends BaseMessage
{
    
{:attribute}
    
    public function __construct()
    {
        parent::__construct();
{:construct_init}
    }
    
{:getMsgId}
    
{:MsgId}
    
    /**
     * write buffer data
     * @throws
     * @param BinaryWriter $buffer
     * @return string
     */
    public function write(BinaryWriter $buffer)
    {
        // TODO: Implement write() method.
{:write_block}
    }
    
    /**
     * read buffer data
     * @param BinaryReader $buffer
     */
    public function read(BinaryReader $buffer)
    {
        // TODO: Implement read() method.
{:read_block}
    }
}';