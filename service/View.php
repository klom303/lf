<?php
/**
 * User: YeJiaLu
 * Date: 2016/3/23
 * Time: 15:05
 */
namespace Service;

class View
{
    const VIEW_BASE_PATH = '/app/views/';
    public $view;
    public $data;

    public function __construct($view)
    {
        $this->view = $view;
    }

    public static function make($viewName = null)
    {
        if(!$viewName){
            throw new \InvalidArgumentException("视图名称不能为空！");
        } else {
            $viewFilePath = self::getFilePath($viewName);
            if( is_file($viewFilePath)){
                return new View($viewFilePath);
            }else{
                throw new \UnexpectedValueException("视图文件不存在！");
            }
        }
    }

    public function with($key , $value = null)
    {
        $this->data[$key] = $value;
        return $this;
    }

    private static function getFilePath($viewName)
    {
        $filePath = str_replace('.','/',$viewName);
        return __BASE__.self::VIEW_BASE_PATH.$filePath.'.php';
    }

    public function __call($method, $parameters)
    {
        if(startsWith($method,'with'))
        {
            return $this->with(snake(substr($method,4)),$parameters[0]);
        }

        throw new \BadMethodCallException("方法 [$method] 不存在 ！");
    }
}