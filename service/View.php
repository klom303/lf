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
    public $data = [];
    public static $shareData=[];

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
            $newView = null;
            if( is_file($viewFilePath)){
                $newView =  new View($viewFilePath);
            }else{
                throw new \UnexpectedValueException("视图文件不存在！");
            }
            if(!empty(self::$shareData)){
                $newView = $newView->withMore(self::$shareData);
            }
            return $newView;
        }
    }

    public static function share($key , $value = null)
    {
        self::$shareData[$key] = $value;
    }

    public function with($key , $value = null)
    {
        $this->data[$key] = $value;
        return $this;
    }

    public function withMore(array $params=[])
    {
        $this->data = array_merge($this->data,$params);
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