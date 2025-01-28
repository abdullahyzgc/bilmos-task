<?php

namespace App\Http\Middleware;

use App\Services\LocationService;
use Closure;
use Illuminate\Http\Request;

class CheckLocation
{
    protected $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next)
    {
        $clientIP = $request->ip();

        if (!$this->locationService->isValidLocationFromIP($clientIP)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ofis lokasyonu dışından giriş/çıkış yapılamaz.',
            ], 403);
        }

        return $next($request);
    }
}
