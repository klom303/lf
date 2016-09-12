<?php
namespace App\Console;

use Service\Socket\ChatBox;

class BootSocket extends Command
{
    public function fire()
    {
        $ws = new ChatBox();
        $ws->run();
    }
}