<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Request;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function joinHoliday(int $holidayId, Request $request)
    {
        try {
            $user = $this->userService->joinHoliday($holidayId);

            return response()->json([
                'message' => 'User joined holiday',
                'data' => [
                    'user' => $user,
                ],
            ], 201);
        } catch (\Exception $e) {
            return response(['message' => 'Error: '.$e->getMessage()], 500);
        }
    }
}
