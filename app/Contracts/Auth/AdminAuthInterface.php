<?php

namespace App\Contracts\Auth;

interface AdminAuthInterface
{
    public function attemptLogin(array $credentials, bool $remember = false);
    public function logout();
    public function sendPasswordResetLink(string $email);
    public function resetPassword(array $data);
} 