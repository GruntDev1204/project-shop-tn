<?php

namespace App\Service\impl;

use App\Repository\extend\INotifiRepo;
use App\Service\extend\IServiceNotifi;

class NotifiService implements IServiceNotifi
{
    private $notifiRepo;
    public function __construct(INotifiRepo $notifiRepo)
    {
        $this->notifiRepo = $notifiRepo;
    }

    public function getAll($req)
    {
        return $this->notifiRepo->getAll($req);
    }

    public function findById($id)
    {
        return $this->notifiRepo->findById($id);
    }

    public function create($data)
    {
        $data['author_name'] = $data['author_name'] ?? "Anonymous";
        $data['image_url'] = $data['image_url'] ?? "https://firebasestorage.googleapis.com/v0/b/trung1204-bdc27.appspot.com/o/NRG%2Fslide%2F1311860.jpeg?alt=media&token=7359dfa0-b2f2-48ae-89ca-3aa62eac01e4";
        return $this->notifiRepo->create($data);
    }

    public function update($id, $data)
    {
        return $this->notifiRepo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->notifiRepo->delete($id);
    }
}
