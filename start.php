<?php
/**
 * Created by PhpStorm.
 * User: ccl
 * Date: 2019/8/22
 * Time: 14:24
 */

require_once __DIR__."/src/BinaryProtocol/ProtocolGenerator.php";
$generator = new protocolGenerator();
$generator->parseXML();
