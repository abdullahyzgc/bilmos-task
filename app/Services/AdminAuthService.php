<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class AdminAuthService
{
    public function attemptLogin(array $credentials, bool $remember = false)
    {
        try {
            if (Auth::guard('admin')->attempt($credentials, $remember)) {
                return true;
            }
            return false;
        } catch (\Exception $e) {
            throw new \Exception('Giriş işlemi sırasında bir hata oluştu: ' . $e->getMessage());
        }
    }

    public function logout()
    {
        try {
            Auth::guard('admin')->logout();
            return true;
        } catch (\Exception $e) {
            throw new \Exception('Çıkış işlemi sırasında bir hata oluştu: ' . $e->getMessage());
        }
    }

    public function sendPasswordResetLink(string $email)
    {
        try {
            return Password::broker('admins')->sendResetLink(['email' => $email]);
        } catch (\Exception $e) {
            throw new \Exception('Şifre sıfırlama bağlantısı gönderilirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    public function resetPassword(array $data)
    {
        try {
            return Password::broker('admins')->reset(
                $data,
                function ($user) use ($data) {
                    $user->forceFill([
                        'password' => bcrypt($data['password']),
                        'remember_token' => Str::random(60),
                    ])->save();

                    event(new PasswordReset($user));
                }
            );
        } catch (\Exception $e) {
            throw new \Exception('Şifre sıfırlama işlemi sırasında bir hata oluştu: ' . $e->getMessage());
        }
    }
} 