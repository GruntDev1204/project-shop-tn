<?php

namespace  App\Service\impl;

use App\Exceptions\APIException;
use App\Repository\extend\IUserRepo;
use App\Service\extend\IServiceUser;

class UserService implements IServiceUser
{
    private $userRepo;
    public function __construct(IUserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function findByHash($hash)
    {
        return $this->userRepo->findByHash($hash);
    }

    public function changeRole($id, $role)
    {
        $roleId =  3;
        switch ($role) {
            case 'Admin':
                $roleId = 2;
                break;
            case 'Customer':
                $roleId = 3;
                break;
            default:
                throw new APIException(400, "Role not valid!");
                break;
        }
        return $this->userRepo->changeRole($id, $roleId);
    }

    public function changeStatus($id, $status)
    {
        $statusValue = 0;
        switch ($status) {
            case 'Active':
                $statusValue = 1;
                break;
            case 'Inactive':
                $statusValue = 0;
                break;
            case 'Blocked':
                $statusValue = 2;
                break;
            default:
                $statusValue = 0;
                break;
        }

        return $this->userRepo->changeStatus($id, $statusValue);
    }

    public function getAll($req)
    {
        return $this->userRepo->getAll($req);
    }

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

    public function delete($id)
    {
        return $this->userRepo->delete($id);
    }

    public function activeUser($hash)
    {
        return $this->userRepo->activeUser($hash);
    }

    public function enable2FA($hash)
    {
        return $this->userRepo->enable2FA($hash);
    }

    public function findByEmail($email)
    {
        return $this->userRepo->findByEmail($email);
    }
}
