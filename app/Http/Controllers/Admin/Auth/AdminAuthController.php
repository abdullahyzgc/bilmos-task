<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Services\AdminAuthService;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    protected $authService;

    public function __construct(AdminAuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(LoginRequest $request)
    {
        try {
            if ($this->authService->attemptLogin(
                $request->only('email', 'password'),
                $request->boolean('remember')
            )) {
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'));
            }

            return back()->withErrors([
                'email' => 'Girdiğiniz bilgiler hatalı.',
            ])->onlyInput('email');
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function logout(Request $request)
    {
        try {
            $this->authService->logout();
            
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login');
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }
} 