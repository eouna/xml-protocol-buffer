<?php
namespace BinaryProtocol\Protocol;
use BinaryProtocol\Protocol\Pet\ReqNoReturn;
use BinaryProtocol\Protocol\Pet\ReqWithSomeProperty;
use BinaryProtocol\Protocol\Pet\ResAllPetCollect;
use \RuntimeException;
class MsgFactory
{
    const _100001 = "return pet collect data";
    const _100002 = "some explain";
    const _100003 = "this message is empty data to send";
    /**
     * class instance map
     * @var array $class_map
     * */
    private static $class_map = [
        self::_100001 => ResAllPetCollect::class,
        self::_100002 => ReqWithSomeProperty::class,
        self::_100003 => ReqNoReturn::class,
    ];
    /**
     * message id index
     * */
    private static $message_map = [
        100001 => ResAllPetCollect::class,     //return pet collect data
        100002 => ReqWithSomeProperty::class,     //some explain
        100003 => ReqNoReturn::class,     //this message is empty data to send
    ];
    /**
     * get message class instance by message id
     * @param string $msg_id
     * @return BaseMessage
     * */
    public static function getInstance(string $msg_id){
        if(isset(self::$message_map[$msg_id]))
            return new self::$class_map[$msg_id];
        if(isset(self::$class_map[$msg_id]))
            return new self::$class_map[$msg_id];
        throw new RuntimeException('MESSAGE DATA NOT FOUND!');
    }
}