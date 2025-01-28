<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\ResetPasswordRequest;
use App\Services\AdminAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class AdminPasswordResetController extends Controller
{
    protected $authService;

    public function __construct(AdminAuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showForgotForm()
    {
        return view('admin.auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        try {
            $status = $this->authService->sendPasswordResetLink($request->email);

            return $status == Password::RESET_LINK_SENT
                ? back()->with('status', __($status))
                : back()->withInput($request->only('email'))
                       ->withErrors(['email' => __($status)]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function showResetForm(Request $request, $token)
    {
        return view('admin.auth.reset-password', ['request' => $request]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
            $status = $this->authService->resetPassword($request->validated());

            return $status == Password::PASSWORD_RESET
                ? redirect()->route('admin.login')->with('status', __($status))
                : back()->withInput($request->only('email'))
                       ->withErrors(['email' => __($status)]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
} 