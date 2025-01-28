<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\Auth\AdminPasswordResetController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Root route'u admin'e yönlendir
Route::get('/', function () {
    return redirect()->route('admin.login');
});

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin ana sayfa kontrolü
    Route::get('/', function () {
        if (auth()->guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('admin.login');
    });

    // Guest routes (login)
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AdminAuthController::class, 'login']);

        // Password Reset Routes
        Route::get('forgot-password', [AdminPasswordResetController::class, 'showForgotForm'])
            ->name('password.request');
        Route::post('forgot-password', [AdminPasswordResetController::class, 'sendResetLink'])
            ->name('password.email');
        Route::get('reset-password/{token}', [AdminPasswordResetController::class, 'showResetForm'])
            ->name('password.reset');
        Route::post('reset-password', [AdminPasswordResetController::class, 'resetPassword'])
            ->name('password.update');
    });

    // Authenticated routes
    Route::middleware('auth:admin')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

        // Users management
        Route::resource('users', UserController::class);

        // API Documentation route
        Route::get('api-docs', [AdminController::class, 'apiDocs'])->name('api-docs');

        // Attendance management
        Route::resource('attendance', AttendanceController::class);
    });
});
