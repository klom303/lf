<?php

define('__PUBLIC__',__DIR__.'/../public');
define('__BASE__',__DIR__.'/../');
define('__APP__',__DIR__.'/../app');
define('__CONFIG__',__DIR__);

//加载必要项
include __APP__.'/function.php';

//加载自动载入
spl_autoload_register(function($class){
    $filePath = explode('\\',$class);
    $class = $filePath[count($filePath)-1];
    array_pop($filePath);
    $filePath = implode('/',$filePath);
    include __BASE__.strtolower($filePath).'/'.$class.'.php' ;
});