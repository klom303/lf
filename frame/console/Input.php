<?php

namespace Frame\Console;

class Input
{
    public $argc = 0;
    public $argv = [];
    public $entrance = null;
    public $commandHandle = null;
    public $commandParams = [];

    public function __construct()
    {
        $this->argc = $_SERVER['argc'];
        $this->argv = $_SERVER['argv'];
        if($this->argc <= 1){
            $this->entrance = $this->argv[0];
        }else{
            $this->commandHandle = $this->argv[1];
            $this->commandParams = array_slice($this->argv,2,$this->argc-1);
        }
    }

}