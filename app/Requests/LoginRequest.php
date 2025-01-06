<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\UserRole;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => [
                'required', 
                'email', 
                'exists:users,email'
            ],
            'password' => [
                'required', 
                'min:6'
            ],
            'role' => [
                'sometimes', 
                'required', 
                Rule::in(UserRole::getAllRoles())
            ]
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.exists' => 'Email tidak terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
            'role.in' => 'Role tidak valid'
        ];
    }
}