<?php

namespace App\Services;

use App\Models\Holiday;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    //not being used in this application
    public function getAllUsers()
    {
        return $this->userRepository->getAllUsers();
    }

    public function getUserById($id)
    {
        return $this->userRepository->getUserById($id);
    }

    public function createUser(array $data)
    {
        DB::beginTransaction();
        try {
            $data['password'] = bcrypt($data['password']);
            $data['email_verified_at'] = now();
            $user = $this->userRepository->createUser($data);
            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();

            throw new \Exception($e->getMessage());
        }

    }

    //not being used in this application
    public function updateUser(int $id, array $user)
    {
        return $this->userRepository->updateUser($id, $user);

    }

    //not being used in this application
    public function destroyUser(int $id)
    {
        return $this->userRepository->destroyUser($id);
    }

    public function joinHoliday(int $holidayId)
    {
        DB::beginTransaction();
        try {
            $user = auth()->user();
            $holiday = Holiday::find($holidayId);

            if (! $holiday) {
                throw new \Exception('Holiday not found');
            }

            if ($user->holidays()->where('holiday_id', $holidayId)->exists()) {
                throw new \Exception('User is already attached to this holiday');
            }

            $user->holidays()->attach($holidayId);
            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();

            throw new \Exception($e->getMessage());
        }
    }
}
