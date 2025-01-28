<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'start_date' => 'required|date|date_format:Y-m-d',
            'end_date' => 'required|date|date_format:Y-m-d|after_or_equal:start_date'
        ];
    }

    public function messages(): array
    {
        return [
            'start_date.required' => 'Başlangıç tarihi zorunludur.',
            'start_date.date' => 'Geçerli bir tarih giriniz.',
            'start_date.date_format' => 'Tarih formatı YYYY-MM-DD şeklinde olmalıdır.',
            'end_date.required' => 'Bitiş tarihi zorunludur.',
            'end_date.date' => 'Geçerli bir tarih giriniz.',
            'end_date.date_format' => 'Tarih formatı YYYY-MM-DD şeklinde olmalıdır.',
            'end_date.after_or_equal' => 'Bitiş tarihi başlangıç tarihinden önce olamaz.',
        ];
    }
} 