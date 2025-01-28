<?php

namespace App\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAttendanceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'check_in' => 'required|date',
            'check_out' => 'nullable|date|after:check_in',
            'description' => 'required_if:is_late,true|required_if:is_early_leave,true',
        ];
    }

    public function messages()
    {
        return [
            'description.required_if' => 'Geç giriş veya erken çıkış durumunda açıklama zorunludur.',
        ];
    }
} 