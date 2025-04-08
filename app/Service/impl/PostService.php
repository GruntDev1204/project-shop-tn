<?php

namespace App\Service\impl;

use App\Repository\extend\IPostRepo;
use App\Service\extend\IServicePost;

class PostService implements IServicePost
{
    private $postRepo;

    public function __construct(IPostRepo $postRepo)
    {
        $this->postRepo = $postRepo;
    }

    public function getAll($reqParam)
    {
        switch ($reqParam['is_own']) {
            case 'true':
                return $this->postRepo->getAllOwns($reqParam);
                break;
            case 'false':
                return $this->postRepo->getAll($reqParam);
                break;
            default:
                return $this->postRepo->getAll($reqParam);
                break;
        }
    }

    public function findById($id)
    {
        return $this->postRepo->findById($id);
    }

    public function create($data)
    {
        $req = [
            'user_id' => $data['user_id'],
            'content' => $data['content'],
            'media' => $data['media'] ?? "noon",
        ];
        return $this->postRepo->create($req);
    }

    public function update($id, $data) {}

    public function delete($id)
    {
        return $this->postRepo->delete($id);
    }
}
