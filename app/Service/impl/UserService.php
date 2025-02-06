<?php

namespace  App\Service\impl;

use App\Repository\extend\IProductRepo as ExtendIProductRepo;
use App\Repository\extend\IUserRepo;
use App\Service\extend\IServiceUser;

class UserService implements IServiceUser
{
    private $userRepo;
    public function __construct(IUserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function getAll() {}

    public function findById($id)
    {
        return $this->userRepo->findById($id);
    }

    public function create($data)
    {
        $dfAvatar = "https://firebasestorage.googleapis.com/v0/b/hotrung1204-36f50.appspot.com/o/Ngoc_Red%2Fdf.jpg?alt=media&token=813909dc-52e3-43d2-b2cd-51c1b912c44e";
        $avatar = isset($data['avatar']) && $data['avatar'] !== "" ? $data['avatar'] : $dfAvatar;
        $data['avatar'] = $avatar;

       
        return $this->userRepo->create($data);
    }

    public function update($id, $data)
    {
        $dfAvatar = "https://firebasestorage.googleapis.com/v0/b/hotrung1204-36f50.appspot.com/o/Ngoc_Red%2Fdf.jpg?alt=media&token=813909dc-52e3-43d2-b2cd-51c1b912c44e";
        $avatar = isset($data['avatar']) && $data['avatar'] !== "" ? $data['avatar'] : $dfAvatar;
        $data['avatar'] = $avatar;

        return $this->userRepo->update($id, $data);
    }

    public function delete($id) {}
}
