<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\HolidayController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::apiResource('holidays', HolidayController::class);
        Route::post('holidays/{holidayId}/join', [UserController::class, 'joinHoliday']);
        Route::get('holidays/{holidayId}/pdf', [HolidayController::class, 'generatePdf']);
    });

});
