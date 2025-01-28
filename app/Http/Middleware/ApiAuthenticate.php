<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class ApiAuthenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        return null;
    }

    protected function unauthenticated($request, array $guards)
    {
        abort(response()->json([
            'status' => 'error',
            'message' => 'Unauthorized. Please login first.',
        ], 401));
    }
} 