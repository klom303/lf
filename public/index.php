<?php
/**
 * This is the entrance of frame
 * User: YeJiaLu
 * Date: 2016/3/22
 * Time: 14:57
 */

define('__PUBLIC__',__DIR__);
define('__BASE__',__DIR__.'/../');
define('__APP__',__DIR__.'/../app');
define('__CONFIG__',__DIR__.'/../config');

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

////Ioc容器绑定服务
//$container = \Frame\Container::getContainer();
//$container->bind('view',function($container,$params){
//    return new Service\View($params);
//});

//加载路由文件
$routes = include __APP__.'/routes.php';

//匹配当前url
$uri = isset($_SERVER['REDIRECT_URL'])?$_SERVER['REDIRECT_URL']:$_SERVER['REQUEST_URI'];
if(!array_key_exists($uri,$routes))
{
    exit("404");
}
list($controllerName,$actionName) = explode('@',$routes[$uri]);
$controllerName = 'App\\Controllers\\'.$controllerName;
$controllerObj = new $controllerName();
$controllerObj->$actionName();