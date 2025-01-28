<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AttendanceLogRequest;
use App\Http\Requests\Api\CheckInRequest;
use App\Http\Requests\Api\CheckOutRequest;
use App\Services\AttendanceService;
use App\Services\LocationService;

class AttendanceController extends Controller
{
    protected $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    public function index(AttendanceLogRequest $request)
    {
        $validated = $request->validated();
        $attendanceLogs = $this->attendanceService->getAttendanceLogs(
            auth()->id(),
            $validated['start_date'],
            $validated['end_date']
        );

        return response()->json([
            'status' => 'success',
            'data' => [
                'attendance_logs' => $attendanceLogs,
                'meta' => [
                    'start_date' => $validated['start_date'],
                    'end_date' => $validated['end_date'],
                    'total_records' => $attendanceLogs->count(),
                ],
            ],
        ]);
    }

    public function checkIn(CheckInRequest $request)
    {
        // Konum doğrulaması
        $locationService = app(LocationService::class);
        if (!$locationService->isValidLocationFromIP($request->ip())) {
            return response()->json([
                'status' => 'error',
                'message' => 'Geçersiz konumdan giriş yapamazsınız.',
            ], 403);
        }

        try {
            $attendance = $this->attendanceService->checkInUser(
                auth()->id(),
                [
                    'description' => $request->late_reason,
                ]
            );

            return response()->json([
                'status' => $attendance->is_late ? 'warning' : 'success',
                'message' => $attendance->is_late ? 'Geç giriş kaydedildi.' : 'Giriş başarıyla kaydedildi.',
                'check_in_time' => $attendance->check_in->format('Y-m-d H:i:s'),
                'attendance_id' => $attendance->id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 403);
        }
    }

    public function checkOut(CheckOutRequest $request)
    {
        // Konum doğrulaması
        $locationService = app(LocationService::class);
        if (!$locationService->isValidLocationFromIP($request->ip())) {
            return response()->json([
                'status' => 'error',
                'message' => 'Geçersiz konumdan giriş yapamazsınız.',
            ], 403);
        }

        try {
            $attendance = $this->attendanceService->checkOutUser(
                auth()->id(),
                [
                    'description' => $request->early_leave_reason,
                ]
            );

            return response()->json([
                'status' => $attendance->is_early_leave ? 'warning' : 'success',
                'message' => $attendance->is_early_leave ? 'Erken çıkış kaydedildi.' : 'Çıkış başarıyla kaydedildi.',
                'check_out_time' => $attendance->check_out->format('Y-m-d H:i:s'),
                'attendance_id' => $attendance->id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 403);
        }
    }
}
