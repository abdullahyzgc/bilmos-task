<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'check_in',
        'check_out',
        'check_in_location',
        'check_out_location',
        'late_reason',
        'early_leave_reason',
        'is_late',
        'is_early_leave',
        'created_at',
    ];

    protected $casts = [
        'is_late' => 'boolean',
        'is_early_leave' => 'boolean',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'created_at' => 'datetime',
        'check_in_location' => 'array',
        'check_out_location' => 'array',
    ];

    // Point verilerini ham halde kaydetmek için
    public $timestamps = false;

    // User ilişkisi
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
