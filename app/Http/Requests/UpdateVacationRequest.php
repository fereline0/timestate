<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVacationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ];
    }

    public function messages()
    {
        return [
            'start_date.required' => 'Пожалуйста, укажите дату начала отпуска.',
            'start_date.date' => 'Дата начала отпуска должна быть корректной датой.',
            'end_date.required' => 'Пожалуйста, укажите дату окончания отпуска.',
            'end_date.date' => 'Дата окончания отпуска должна быть корректной датой.',
            'end_date.after_or_equal' => 'Дата окончания отпуска должна быть равной или позже даты начала.',
        ];
    }
}
