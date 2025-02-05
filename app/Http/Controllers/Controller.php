<?php

namespace App\Http\Controllers;

use App\Exceptions\AuthException;
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

    protected function getAuth()
    {
        $user = auth()->user();

        if (!$user) {
            throw new AuthException();
        }

        return $user;
    }
}
