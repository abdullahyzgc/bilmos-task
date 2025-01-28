<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'check_in' => 'required|date',
            'check_out' => 'nullable|date|after:check_in',
            'late_reason' => 'nullable|string|max:255',
            'early_leave_reason' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'check_in.required' => 'Giriş saati zorunludur.',
            'check_in.date' => 'Geçerli bir tarih giriniz.',
            'check_out.date' => 'Geçerli bir tarih giriniz.',
            'check_out.after' => 'Çıkış saati giriş saatinden sonra olmalıdır.',
            'late_reason.max' => 'Geç kalma nedeni en fazla 255 karakter olabilir.',
            'early_leave_reason.max' => 'Erken çıkış nedeni en fazla 255 karakter olabilir.',
        ];
    }
} 