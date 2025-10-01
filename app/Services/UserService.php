<?php
namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    protected $repo;

    public function __construct(UserRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAllUsers()
    {
        return $this->repo->all();
    }

    public function getUser($id)
    {
        return $this->repo->find($id);
    }

    public function createUser(array $data)
    {
        return $this->repo->create($data);
    }

    public function updateUser($id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    public function deleteUser($id)
    {
        return $this->repo->delete($id);
    }
}