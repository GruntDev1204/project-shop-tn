<?php

namespace App\Repository\impl;

use App\Exceptions\APIException;
use App\Models\Notifi;
use App\Repository\BaseRepository;
use App\Repository\extend\INotifiRepo;

class NotifiRepo extends BaseRepository implements INotifiRepo
{
    public function getAll($req)
    {
        return Notifi::all();
    }

    public function findById($id)
    {
        $data =  Notifi::find($id);
        if (!$data) {
            throw new APIException(404, "Notifi not found!");
        } else {
            return $data;
        }
    }

    public function create($data)
    {
        return Notifi::create($data);
    }

    public function update($id, $data)
    {
        $notifi = $this->findById($id);
        $notifi->update($data);
        return $notifi;
    }

    public function delete($id)
    {
        $notifi = $this->findById($id);
        $notifi->delete();
        return $notifi;
    }
}
