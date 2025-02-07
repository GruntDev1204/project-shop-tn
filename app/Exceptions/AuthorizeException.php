<?php

namespace App\Exceptions;

use Exception;

class AuthorizeException extends Exception
{
    protected $message;

    public function __construct($message = 'Role authorization failed!')
    {
        parent::__construct($message);
    }
    public function render()
    {
        return response()->json([
            'error' => $this->message,
            'status' => 403,
        ], 403);
    }
}
