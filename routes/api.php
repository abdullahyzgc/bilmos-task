<?php

use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);

    Route::middleware('auth.api:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::middleware(['check.location', 'check.working.hours'])->group(function () {
            Route::post('check-in', [AttendanceController::class, 'checkIn'])
                ->whereIn('late_reason', ['required_if:is_late,true', 'string', 'min:10', 'max:255']);

            Route::post('check-out', [AttendanceController::class, 'checkOut'])
                ->whereIn('early_leave_reason', ['required_if:is_early_leave,true', 'string', 'min:10', 'max:255']);
        });
        Route::get('attendance-logs', [AttendanceController::class, 'index']);
    });
});
