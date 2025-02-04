<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkingTimeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'begin' => 'required',
            'end' => 'required|after:begin',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'Пожалуйста, выберите пользователя.',
            'user_id.exists' => 'Выбранный пользователь не существует.',
            'date.required' => 'Пожалуйста, укажите дату.',
            'date.date' => 'Пожалуйста, введите корректную дату.',
            'begin.required' => 'Пожалуйста, укажите время начала.',
            'end.required' => 'Пожалуйста, укажите время окончания.',
            'end.after' => 'Время окончания должно быть позже времени начала.',
        ];
    }
}
