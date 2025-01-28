<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'phone' => 'required|string|max:10',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|max:8|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Ad alanı zorunludur',
            'surname.required' => 'Soyad alanı zorunludur',
            'phone.required' => 'Telefon alanı zorunludur',
            'email.required' => 'E-posta adresi zorunludur',
            'email.email' => 'Geçerli bir e-posta adresi giriniz',
            'email.unique' => 'Bu e-posta adresi zaten kullanımda',
            'password.required' => 'Şifre zorunludur',
            'password.min' => 'Şifre en az 6 karakter olmalıdır',
            'password.max' => 'Şifre en fazla 8 karakter olmalıdır',
            'password.confirmed' => 'Şifre tekrarı geçerli değil'
        ];
    }
}
