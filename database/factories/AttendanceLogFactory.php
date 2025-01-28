<?php

namespace Database\Factories;

use App\Models\AttendanceLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class AttendanceLogFactory extends Factory
{
    protected $model = AttendanceLog::class;

    public function definition()
    {
        // Son 30 gün içinde rastgele bir tarih seç
        $date = $this->faker->dateTimeBetween('-30 days', 'now');
        
        // Seçilen tarihin başlangıcına git (00:00)
        $dayStart = Carbon::parse($date)->startOfDay();
        
        // Mesai başlangıç ve bitiş saatleri (örnek: 08:00 - 17:00)
        $workStart = 8; // 08:00
        $workEnd = 17;  // 17:00
        
        // Geç gelme ve erken çıkma olasılıkları
        $isLate = $this->faker->boolean(20); // %20 ihtimalle geç kalma
        $isEarlyLeave = $this->faker->boolean(15); // %15 ihtimalle erken çıkma

        // Giriş saatini belirle
        if ($isLate) {
            // Geç kalma durumunda 08:15 - 09:30 arası
            $checkInHour = $this->faker->numberBetween($workStart, $workStart + 1);
            $checkInMinute = $this->faker->numberBetween(15, 59);
        } else {
            // Normal giriş 07:45 - 08:15 arası
            $checkInHour = $workStart;
            $checkInMinute = $this->faker->numberBetween(-15, 15);
        }

        // Giriş zamanını ayarla
        $checkIn = (clone $dayStart)->addHours($checkInHour)->addMinutes($checkInMinute);

        // Çıkış saatini belirle
        if ($isEarlyLeave) {
            // Erken çıkış durumunda 15:30 - 16:45 arası
            $checkOutHour = $this->faker->numberBetween($workEnd - 2, $workEnd);
            $checkOutMinute = $this->faker->numberBetween(0, 45);
        } else {
            // Normal çıkış 17:00 - 18:00 arası
            $checkOutHour = $workEnd;
            $checkOutMinute = $this->faker->numberBetween(0, 60);
        }

        // Çıkış zamanını ayarla
        $checkOut = (clone $dayStart)->addHours($checkOutHour)->addMinutes($checkOutMinute);

        return [
            'user_id' => User::factory(),
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'check_in_location' => null,
            'check_out_location' => null,
            'is_late' => $isLate,
            'late_reason' => $isLate ? $this->faker->randomElement([
                'Trafik yoğunluğu',
                'Toplu taşıma gecikmesi',
                'Sağlık sorunu',
                'Hava muhalefeti',
                'Aile acil durumu'
            ]) : null,
            'is_early_leave' => $isEarlyLeave,
            'early_leave_reason' => $isEarlyLeave ? $this->faker->randomElement([
                'Doktor randevusu',
                'Aile acil durumu',
                'Banka işlemleri',
                'Özel durum',
                'Sağlık sorunu'
            ]) : null,
            'created_at' => $checkIn,
            'updated_at' => $checkIn,
        ];
    }
} 