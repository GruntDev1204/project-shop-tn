<?php

namespace App\Exceptions;

use Exception;

class APIException extends Exception
{
    protected $code;
    protected $message;

    public function __construct($code, $message)
    {
        parent::__construct($message, $code); // Gọi constructor của class Exception
        $this->code = $code;
        $this->message = $message;
    }
    public function render()
    {
        return response()->json([
            'status' => $this->code,
            'message' => $this->message,
        ], $this->code);
    }
}
