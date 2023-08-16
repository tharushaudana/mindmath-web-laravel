<?php

namespace App\Http\Requests\student;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'min:5'],
            'grade' => ['required', 'exists:grades,id'],
        ];
    }
}
