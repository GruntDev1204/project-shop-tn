<?php

namespace App\Exceptions;

use Exception;

class AuthException extends Exception
{
    protected $message;

    public function __construct($message = 'Unauthorized access')
    {
        parent::__construct($message);
    }
    public function render()
    {
        return response()->json([
            'error' => $this->message,
            'status' => 401,
        ], 401);
    }
}
