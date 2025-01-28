<?php

namespace App\Services;

use App\Models\AttendanceLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class AttendanceService
{
    public function getAttendanceLogs($userId, $startDate, $endDate)
    {
        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();

        return AttendanceLog::where('user_id', $userId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($attendance) {
                return $this->formatAttendanceLog($attendance);
            });
    }

    public function createAttendance(array $data)
    {
        $checkInDateTime = Carbon::parse($data['check_in']);
        $checkOutDateTime = isset($data['check_out']) ? Carbon::parse($data['check_out']) : null;

        // Mesai kontrollerini yap
        $this->validateWorkingHours($checkInDateTime, $checkOutDateTime, $data);

        // Aynı gün kontrolü
        $this->validateDuplicateEntry($data['user_id'], $checkInDateTime);

        $data['is_late'] = $this->isLateCheckIn($checkInDateTime);
        $data['is_early_leave'] = $checkOutDateTime ? $this->isEarlyCheckOut($checkOutDateTime) : false;

        return AttendanceLog::create($data);
    }

    public function updateAttendance(AttendanceLog $attendance, array $data)
    {
        $checkInDateTime = Carbon::parse($data['check_in']);
        $checkOutDateTime = isset($data['check_out']) ? Carbon::parse($data['check_out']) : null;

        // Mesai kontrollerini yap
        $this->validateWorkingHours($checkInDateTime, $checkOutDateTime, $data);

        $data['is_late'] = $this->isLateCheckIn($checkInDateTime);
        $data['is_early_leave'] = $checkOutDateTime ? $this->isEarlyCheckOut($checkOutDateTime) : false;

        $attendance->update($data);

        return $attendance;
    }

    public function deleteAttendance(AttendanceLog $attendance)
    {
        return $attendance->delete();
    }

    private function validateWorkingHours($checkIn, $checkOut, $data)
    {
        if ($this->isLateCheckIn($checkIn) && empty($data['late_reason'])) {
            throw new \App\Exceptions\AttendanceException('Geç giriş için açıklama zorunludur.');
        }

        if ($checkOut && $this->isEarlyCheckOut($checkOut) && empty($data['early_leave_reason'])) {
            throw new \App\Exceptions\AttendanceException('Erken çıkış için açıklama zorunludur.');
        }
    }

    private function validateDuplicateEntry($userId, $checkIn)
    {
        $existingLog = AttendanceLog::where('user_id', $userId)
            ->whereDate('check_in', $checkIn->toDateString())
            ->first();

        if ($existingLog) {
            throw new \Exception('Bu personel için bugün zaten kayıt mevcut.');
        }
    }

    private function isLateCheckIn($time)
    {
        $startTime = Carbon::parse(Config::get('working_hours.start_time'));
        $toleranceMinutes = Config::get('working_hours.tolerance_minutes');
        $startTime->addMinutes($toleranceMinutes);

        return $time->format('H:i') > $startTime->format('H:i');
    }

    private function isEarlyCheckOut($time)
    {
        $endTime = Carbon::parse(Config::get('working_hours.end_time'));
        $toleranceMinutes = Config::get('working_hours.early_leave_tolerance');

        // Günün bitiş saatini al
        $endTimeToday = Carbon::today()->setTimeFrom($endTime);
        $endTimeToday->subMinutes($toleranceMinutes);

        return $time->lt($endTimeToday);
    }

    public function checkInUser($userId, array $data)
    {
        $now = Carbon::now();
        DB::beginTransaction();

        try {
            $this->validateDuplicateEntry($userId, $now);

            $isLate = $this->isLateCheckIn($now);
            if ($isLate && empty($data['description'])) {
                throw new \Exception('Geç giriş için açıklama zorunludur.');
            }

            $attendanceData = [
                'user_id' => $userId,
                'check_in' => $now,
                'late_reason' => $data['description'] ?? null,
                'is_late' => $isLate,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            $attendance = AttendanceLog::create($attendanceData);

            DB::commit();

            return $attendance;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function checkOutUser($userId, array $data)
    {
        $now = Carbon::now();
        DB::beginTransaction();

        try {
            $attendance = AttendanceLog::where('user_id', $userId)
            ->whereDate('check_in', $now->toDateString())
            ->whereNull('check_out')
            ->first();

            if (!$attendance) {
                throw new \Exception('Aktif giriş kaydı bulunamadı.');
            }

            $isEarlyLeave = $this->isEarlyCheckOut($now);

            if ($isEarlyLeave && empty($data['description'])) {
                throw new \Exception('Erken çıkış için açıklama zorunludur.');
            }

            $attendance->check_out = $now;
            $attendance->early_leave_reason = $data['description'] ?? null;
            $attendance->is_early_leave = $isEarlyLeave;
            $attendance->updated_at = $now;
            $attendance->save();

            DB::commit();

            return $attendance;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function formatAttendanceLog($attendance)
    {
        return [
            'id' => $attendance->id,
            'check_in' => $attendance->check_in->format('Y-m-d'),
            'check_out' => $attendance->check_out->format('Y-m-d'),
            'is_late' => $attendance->is_late,
            'is_early_leave' => $attendance->is_early_leave,
            'late_reason' => $attendance->late_reason,
            'early_leave_reason' => $attendance->early_leave_reason,
            'created_at' => $attendance->created_at->format('Y-m-d H:i:s'),
        ];
    }

    private function hasExistingAttendance($userId, $date)
    {
        return AttendanceLog::where('user_id', $userId)
            ->whereDate('check_in', $date->toDateString())
            ->exists();
    }

    private function getActiveAttendance($userId)
    {
        return AttendanceLog::where('user_id', $userId)
            ->whereNull('check_out')
            ->latest('check_in')
            ->first();
    }

    private function isWeekend($date)
    {
        $weekendDays = Config::get('working_hours.weekend_days', ['Saturday', 'Sunday']);

        return in_array($date->format('l'), $weekendDays);
    }
}
