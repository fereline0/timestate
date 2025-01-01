<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Пожалуйста, введите название отдела.',
            'name.string' => 'Название отдела должно быть строкой.',
            'name.max' => 'Название отдела не должно превышать 255 символов.',
        ];
    }
}
