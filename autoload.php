<?php
/**
 * Created by PHPStorm
 * User: ccl
 * Date: 2019/08/23
 * Time: 19:52
 */
 
function classLoader($class){
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $file = __DIR__ . '/src/' . $path . '.php';
    if (file_exists($file))
        require_once $file;
}

spl_autoload_register('classLoader');
