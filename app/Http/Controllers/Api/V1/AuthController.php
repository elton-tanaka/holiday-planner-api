<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Requests\V1\LoginAuthRequest;
use App\Http\Controllers\Requests\V1\RegisterAuthRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(RegisterAuthRequest $request)
    {
        try {
            $user = $this->userService->createUser($request->all());
            $accessToken = $user->createToken('authToken')->accessToken;

            return response(['user' => $user, 'access_token' => $accessToken]);

        } catch (\Exception $e) {
            return response(['message' => 'Error: '.$e->getMessage()], 500);
        }
    }

    public function login(LoginAuthRequest $request)
    {
        try {
            if (! Auth::attempt($request->all())) {
                return response(['message' => 'Invalid credentials']);
            }

            $user = Auth::user();
            $accessToken = $user->createToken('authToken')->accessToken;

            return response(['user' => $user, 'access_token' => $accessToken]);

        } catch (\Exception $e) {
            return response(['message' => 'Error: '.$e->getMessage()], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->token()->revoke();

            return response(['message' => 'Successfully logged out']);

        } catch (\Exception $e) {
            return response(['message' => 'Error: '.$e->getMessage()], 500);
        }
    }
}
