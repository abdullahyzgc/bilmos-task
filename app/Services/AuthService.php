<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;

class AuthService
{
    public function register(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'token' => $token,
            'user' => $user,
        ];
    }

    public function login(array $credentials)
    {
        if (!Auth::attempt($credentials)) {
            return false;
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'token' => $token,
            'user' => $user,
        ];
    }

    public function forgotPassword(string $email)
    {
        $user = User::where('email', $email)->first();
        $resetCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $user->update([
            'reset_code' => $resetCode,
            'reset_code_expires_at' => now()->addHours(1),
        ]);

        Mail::to($user->email)->send(new ResetPasswordMail($resetCode));

        return true;
    }

    public function resetPassword(array $data)
    {
        $user = User::where('email', $data['email'])
            ->where('reset_code', $data['code'])
            ->where('reset_code_expires_at', '>', now())
            ->first();

        if (!$user) {
            return false;
        }

        $user->update([
            'password' => Hash::make($data['password']),
            'reset_code' => null,
            'reset_code_expires_at' => null,
        ]);

        return true;
    }

    public function attemptLogin(array $credentials, string $guard = 'web')
    {
        if (Auth::guard($guard)->attempt($credentials)) {
            request()->session()->regenerate();
            return true;
        }
        return false;
    }

    public function logout(string $guard = 'web')
    {
        Auth::guard($guard)->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }
} 