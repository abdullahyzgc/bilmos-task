<?php

namespace App\Services;

use App\Models\User;
use App\Models\AttendanceLog;
use Carbon\Carbon;

class DashboardService
{
    public function getDashboardStats()
    {
        try {
            return [
                'total_users' => $this->getTotalUsers(),
                'today_attendance' => $this->getTodayAttendance(),
                'late_entries' => $this->getTodayLateEntries(),
                'early_leaves' => $this->getTodayEarlyLeaves(),
            ];
        } catch (\Exception $e) {
            throw new \Exception('Dashboard istatistikleri alınırken bir hata oluştu: ' . $e->getMessage());
        }
    }

    private function getTotalUsers()
    {
        return User::count();
    }

    private function getTodayAttendance()
    {
        return AttendanceLog::whereDate('check_in', today())->count();
    }

    private function getTodayLateEntries()
    {
        return AttendanceLog::where('is_late', true)
            ->whereDate('check_in', today())
            ->count();
    }

    private function getTodayEarlyLeaves()
    {
        return AttendanceLog::where('is_early_leave', true)
            ->whereDate('check_out', today())
            ->count();
    }
} 