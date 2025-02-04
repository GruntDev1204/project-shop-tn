<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function returnJson($data, $code, $mesage)
    {
        return response()->json([
            'status' => $code,
            'message' => $mesage,
            'data' => $data
        ], $code);
    }
}
