<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize()
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
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'department_id' => [
                'required',
                'exists:departments,id',
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Пожалуйста, введите ваше имя.',
            'name.string' => 'Имя должно быть строкой.',
            'name.max' => 'Имя не должно превышать 255 символов.',
            'email.required' => 'Пожалуйста, введите ваш адрес электронной почты.',
            'email.string' => 'Электронная почта должна быть строкой.',
            'email.lowercase' => 'Электронная почта должна быть в нижнем регистре.',
            'email.email' => 'Пожалуйста, введите корректный адрес электронной почты.',
            'email.max' => 'Электронная почта не должна превышать 255 символов.',
            'email.unique' => 'Этот адрес электронной почты уже используется.',
            'department_id.required' => 'Пожалуйста, выберите отдел.',
            'department_id.exists' => 'Выбранный отдел не существует.',
        ];
    }
}
