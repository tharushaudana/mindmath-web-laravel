<?php

namespace App\Http\Requests\student;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:students,email'],
            'grade' => ['required', 'exists:grades,id'],
            'password' => ['required', 'min:8', 'confirmed'],
        ];
    }
}
