<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class CheckWorkingHours
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next)
    {
        $now = Carbon::now();

        $startTime = Carbon::createFromTimeString(config('working_hours.start_time'));
        $endTime = Carbon::createFromTimeString(config('working_hours.end_time'));

        $isWorkingDay = !in_array($now->format('l'), config('working_hours.weekend_days'));
        $isWorkingHour = $now->between(
            $startTime->subMinutes(config('working_hours.tolerance_minutes')),
            $endTime->addMinutes(config('working_hours.early_leave_tolerance'))
        );

        if (!$isWorkingDay || !$isWorkingHour) {
            return response()->json([
                'message' => 'Mesai saatleri dışında işlem yapamazsınız',
                'working_hours' => sprintf(
                    'Pazartesi-Cuma %s-%s',
                    config('working_hours.start_time'),
                    config('working_hours.end_time')
                ),
            ], 403);
        }

        return $next($request);
    }
}
