<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSickLeaveRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'Пожалуйста, выберите пользователя.',
            'user_id.exists' => 'Выбранный пользователь не существует.',
            'start_date.required' => 'Пожалуйста, укажите дату начала больничного.',
            'start_date.date' => 'Дата начала больничного должна быть корректной датой.',
            'end_date.required' => 'Пожалуйста, укажите дату окончания больничного.',
            'end_date.date' => 'Дата окончания больничного должна быть корректной датой.',
            'end_date.after_or_equal' => 'Дата окончания больничного должна быть равной или позже даты начала.',
        ];
    }
}
