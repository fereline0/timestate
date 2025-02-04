<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkingTimeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'date' => 'required|date',
            'begin' => 'required',
            'end' => 'nullable|after:begin',
        ];
    }

    public function messages()
    {
        return [
            'date.required' => 'Пожалуйста, укажите дату.',
            'date.date' => 'Дата должна быть корректной датой.',
            'begin.required' => 'Пожалуйста, укажите время начала.',
            'end.after' => 'Время окончания должно быть позже времени начала.',
        ];
    }
}
