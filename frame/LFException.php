<?php

namespace Frame;

use Exception;

class LFException extends Exception
{
    public function getInfo()
    {
        $message = [
            'code' => $this->getCode(),
            'message' => $this->getMessage(),
            'file' => $this->getFile(),
            'line' => $this->getLine()
        ];

        return $message;
    }
}