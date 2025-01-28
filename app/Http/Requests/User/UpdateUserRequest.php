<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'phone' => 'required|string|max:10',
            'email' => 'required|email|unique:users,email,'.$this->user->id,
            'password' => 'nullable|string|min:6|max:8',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Ad alanı zorunludur.',
            'surname.required' => 'Soyad alanı zorunludur.',
            'phone.required' => 'Telefon alanı zorunludur.',
            'email.required' => 'E-posta alanı zorunludur.',
            'email.unique' => 'Bu e-posta adresi zaten kullanımda.',
        ];
    }
} 