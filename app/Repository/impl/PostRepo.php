<?php

namespace App\Repository\impl;

use App\Exceptions\APIException;
use App\Models\Posts;
use App\Repository\BaseRepository;
use App\Repository\extend\IPostRepo;

class PostRepo extends BaseRepository implements IPostRepo
{
    public function getAllOwns($req)
    {
        return Posts::where('user_id', $req['user_id'])->get() ?? ["content" => "chả có con mẹ gì cả"];
    }

    public function getAll($reqParam)
    {
        return Posts::all() ??  ["content" => "chả có con mẹ gì cả"];
    }

    public function findById($id)
    {
        return Posts::where("id", $id)->first() ?? throw new APIException(404, "post not found!");
    }

    public function create($data)
    {
        return Posts::create($data);
    }

    public function update($id, $data) {}

    public function delete($id)
    {

        $post = $this->findById($id);
        $post->delete();
        return true;
    }
}
