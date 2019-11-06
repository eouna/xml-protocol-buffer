<?php
/**
 * Created by PhpStorm.
 * User: ccl
 * Date: 2019/8/22
 * Time: 14:24
 */

require __DIR__ . "/autoload.php";
require __DIR__ . "/src/BinaryProtocol/ProtocolGenerator.php";
use BinaryProtocol\Protocol\MsgFactory;

$generator = new ProtocolGenerator();
$generator->parseXML();

$class = MsgFactory::getInstance(MsgFactory::_100001);
var_dump($class->zPowerLv);