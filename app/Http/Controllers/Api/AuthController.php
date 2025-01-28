<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\ForgotPasswordRequest;
use App\Http\Requests\Api\ResetPasswordRequest;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $result = $this->authService->register($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Kullanıcı başarıyla oluşturuldu',
            'data' => $result,
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $result = $this->authService->login($request->validated());

        if (!$result) {
            return response()->json([
                'status' => 'error',
                'message' => 'The provided credentials are incorrect.',
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged in',
            'data' => $result,
        ]);
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $this->authService->forgotPassword($request->email);

        return response()->json([
            'message' => 'Şifre sıfırlama kodu e-posta adresinize gönderildi',
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $result = $this->authService->resetPassword($request->validated());

        if (!$result) {
            return response()->json([
                'message' => 'Geçersiz veya süresi dolmuş kod',
            ], 400);
        }

        return response()->json([
            'message' => 'Şifreniz başarıyla güncellendi',
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'Başarıyla çıkış yapıldı',
        ]);
    }
}
