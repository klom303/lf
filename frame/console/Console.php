<?php

namespace Frame\Console;

use App\Console\Command;
use Frame\Console\Input;

class Console
{
    /**
     * @var Input
     */
    public $input;

    public function run(Input $input)
    {
        $this->input = $input;
        $this->beforeHandle();
        $this->handle();
        $this->afterHandle();
    }

    private function beforeHandle()
    {
        if($this->input->argc == 1){
            $this->showWelcome();
            exit;
        }
    }

    private function handle()
    {
        $command = $this->getCommand();
        if(!$command instanceof Command){
            $this->printScreen('command must extend from Command class.');
        }
        $command->fire();
    }

    private function afterHandle()
    {

    }

    private function showWelcome()
    {
        $this->printScreen('----- Welcome To lf Frame Command Mode -----');
    }

    private function printScreen($message)
    {
        echo $message."\n";
    }

    private function getCommand()
    {
        $commands = include __CONFIG__.'/console.php';
        if(!isset($commands[trim($this->input->commandHandle)])){
            $this->printScreen('command '.$this->input->commandHandle.' is not found');
            exit;
        }
        return new $commands[trim($this->input->commandHandle)];
    }

}