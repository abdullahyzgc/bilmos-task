<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAttendanceRequest;
use App\Http\Requests\Admin\UpdateAttendanceRequest;
use App\Models\AttendanceLog;
use App\Services\AttendanceService;

class AttendanceController extends Controller
{
    protected $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    public function index()
    {
        $attendanceLogs = AttendanceLog::with('user')
            ->latest()
            ->get();

        return view('admin.attendance.index', compact('attendanceLogs'));
    }

    public function store(StoreAttendanceRequest $request)
    {
        try {
            $this->attendanceService->createAttendance($request->validated());

            return redirect()->route('admin.attendance.index')
                ->with('success', 'Giriş/çıkış kaydı oluşturuldu.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function edit(AttendanceLog $attendance)
    {
        return view('admin.attendance.edit', compact('attendance'));
    }

    public function update(UpdateAttendanceRequest $request, AttendanceLog $attendance)
    {
        try {
            $this->attendanceService->updateAttendance($attendance, $request->validated());

            return redirect()->route('admin.attendance.index')
                ->with('success', 'Kayıt güncellendi.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function destroy(AttendanceLog $attendance)
    {
        $this->attendanceService->deleteAttendance($attendance);

        return redirect()->route('admin.attendance.index')
            ->with('success', 'Kayıt silindi.');
    }
}
