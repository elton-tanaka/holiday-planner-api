<?php

use App\Http\Controllers\Api\V1\HolidayController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::apiResource('holidays', HolidayController::class);
});
