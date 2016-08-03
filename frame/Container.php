<?php
/**
 * User: YeJiaLu
 * Date: 2016/3/23
 * Time: 15:10
 */
namespace Frame;

class Container
{
    /**
     * @var Container
     */
    protected static $instance;
    protected $binds;
    protected $instances;

    private function __construct()
    {
    }
    private function __clone()
    {
    }

    public static function getContainer(){
        if(!static::$instance instanceof self){
            static::$instance = new self();
        }
        return static::$instance;
    }

    public function bind($abstract, $concrete)
    {
        if ($concrete instanceof \Closure) {
            $this->binds[$abstract] = $concrete;
        } else {
            $this->instances[$abstract] = $concrete;
        }
    }

    public function make($abstract , $parameters = [])
    {
        if(isset($this->instances[$abstract])){
            return $this->instances[$abstract];
        }
        array_unshift($parameters,$this);
        return call_user_func_array($this->binds[$abstract],$parameters);
    }

    public static function __callStatic($name, $arguments)
    {
        return static::$instance->make($name,$arguments);
    }
}