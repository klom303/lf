<?php
/**
 * This is the entrance of frame
 * User: YeJiaLu
 * Date: 2016/3/22
 * Time: 14:57
 */

include __DIR__.'/../config/bootstrap.php';

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

define('__ACCESS_CONTROLLER__',$controllerName);
define('__ACCESS_FUNCTION__',$actionName);

$controllerName = 'App\\Controllers\\'.$controllerName;
$controllerObj = new $controllerName();
$controllerObj->$actionName();