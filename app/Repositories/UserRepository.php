<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAllUsers()
    {
        return $this->user->all();
    }

    public function getUserById($id)
    {
        return $this->user->findOrFail($id);
    }

    public function createUser(array $user)
    {
        return $this->user->create($user);
    }

    public function updateUser(int $id, array $data)
    {
        $user = $this->getUserById($id);
        $user->update($data);

        return $user;
    }

    public function destroyUser(int $id)
    {
        $user = $this->getUserById($id);
        $user->delete();

        return $user;
    }
}
