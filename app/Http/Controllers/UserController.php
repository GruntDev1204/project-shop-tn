<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserReq;
use App\Models\User;

class UserController extends Controller
{
    public function signup(UserReq $request)
    {
        $dfAvatar = "https://firebasestorage.googleapis.com/v0/b/hotrung1204-36f50.appspot.com/o/Ngoc_Red%2Fdf.jpg?alt=media&token=813909dc-52e3-43d2-b2cd-51c1b912c44e";
        $data = $request->all();
        $avatar = isset($data['avatar']) && $data['avatar'] !== "" ? $data['avatar'] : $dfAvatar;

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'avatar' => $avatar,
            'password' => bcrypt($data['password']),
        ]);

        return $this->returnJson($user, 200, "resigter success!");
    }

    public function updateProfile(UserReq $request)
    {
        $user = auth()->user();
        if (!$user) {
            return $this->returnJson(null, 401, "Unauthorized đitmemày");
        }

        $dfAvatar = "https://firebasestorage.googleapis.com/v0/b/hotrung1204-36f50.appspot.com/o/Ngoc_Red%2Fdf.jpg?alt=media&token=813909dc-52e3-43d2-b2cd-51c1b912c44e";
        $data = $request->all();
        $avatar = isset($data['avatar']) && $data['avatar'] !== "" ? $data['avatar'] : $dfAvatar;

        $dataUpdate = User::find($user->id);
        $dataUpdate->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'avatar' => $avatar,
        ]);

        return $this->returnJson($dataUpdate, 200, "update successful!");
    }
}
