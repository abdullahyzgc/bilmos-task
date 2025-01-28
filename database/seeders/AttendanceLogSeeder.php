<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AttendanceLog;
use Illuminate\Database\Seeder;

class AttendanceLogSeeder extends Seeder
{
    public function run()
    {
        // Her kullanıcı için 10 attendance log oluştur
        User::all()->each(function ($user) {
            AttendanceLog::factory()
                ->count(10)
                ->create([
                    'user_id' => $user->id
                ]);
        });
    }
}
