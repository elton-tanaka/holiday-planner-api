<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface
{
    public function getAllUsers();

    public function getUserById($id);

    public function createUser(array $user);

    public function updateUser(int $id, array $user);

    public function destroyUser(int $id);
}
