<?php
/**
 * Created by PhpStorm.
 * User: ccl
 * Date: 2019/8/22
 * Time: 14:04
 */
return [
    'file' => [//basic file load path config
        'autoloader_location' => ['name' => '/../../autoload.php', 'comment' => 'autoload file'],
        'base_message_location' => ['name' => '/BaseMessage.php', 'comment' => 'base message class'],
        'base_struct_location' => ['name' => '/BaseStruct.php', 'comment' => 'base message class'],
        'msg_factory_message_location' => ['name' => '/protocol/MsgFactory.php', 'comment' => 'message factory class'],
        'template_file_location' => ['name' => 'template/template.php', 'comment' => 'protocol template path'],
        'default_location' => ['name' => '/', 'comment' => 'default file place']
    ],
    'directory' => [//basic directory load path config
        'protocol_directory' => ['name' => '/protocol', 'comment' => 'protocol code directory'],
        'xml_config_directory' => ['name' => '/config/xml/', 'comment' => 'protocol config directory'],
        'default_directory' => ['name' => '/', 'comment' => 'default directory place'],
    ],
    'namespace' => 'BinaryProtocol\Protocol',
    'template_anchor' => [//template tags
        "namespace" => "{:name_space}", "class_function" => "{:class_function}", "class_name" => "{:class_name}",
        "attribute" => "{:attribute}", "construct_init" => "{:construct_init}", "write_block" => "{:write_block}",
        "getMsgId" => "{:getMsgId}", "MsgId" => "{:MsgId}", "read_block" => "{:read_block}", "description" => "{:description}",
        "base_message" => "{:base_message}", "class_map" => "{:class_map}", "const_defines" => "{:const_defines}",
        "message_map" => "{:message_map}", "extender" => "{:extender}",
    ],
    'author' => 'ccl',//author
    'generator' => 'PHPStorm',//IDE name
    'alias_list' => [//tags alias
        'name' => 'name',
        'explain' => 'explain',
        'struct' => 'struct',
        'field' => 'field',
        'list' => 'list',
        'message' => 'message',
        'class' => 'class',
        'msg_id' => 'msgId'
    ],
    'class_type' => [//data type alias
        'byte' => 'byte',
        'int' => 'int',
        'string' => 'string',
        'short' => 'short',
        'long' => 'long',
        'float' => 'float',
    ],
    'type_default_value' => [//data type default value
        'int' => 0,
        'string' => "''",
        'byte' => true,
        'short' => 0,
        'long' => 0,
        'float' => .0,
    ],
    'buffer_alias' => [//data type reflect the method
        'r_int' => 'readInt32',
        'r_string' => 'readUTFString',
        'r_byte' => 'readChar',
        'r_short' => 'readShort',
        'r_long' => 'readInt64',
        'r_float' => 'readFloat',
        'w_int' => 'writeInt32',
        'w_byte' => 'writeChar',
        'w_string' => 'writeUTFString',
        'w_short' => 'writeShort',
        'w_long' => 'writeInt64',
        'w_float' => 'writeFloat',
    ]
];