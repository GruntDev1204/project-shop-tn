<?php

namespace App\Exceptions;

use Exception;

class DenyPermissionException extends Exception
{
    protected $message;

    public function __construct($message = 'Access Denied!')
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
