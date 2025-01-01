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
            'begin' => 'required|date_format:H:i:s',
            'end' => 'nullable|date_format:H:i:s|after:begin',
        ];
    }

    public function messages()
    {
        return [
            'date.required' => 'Пожалуйста, укажите дату.',
            'date.date' => 'Дата должна быть корректной датой.',
            'begin.required' => 'Пожалуйста, укажите время начала.',
            'begin.date_format' => 'Время начала должно быть в формате HH:MM:SS.',
            'end.date_format' => 'Время окончания должно быть в формате HH:MM:SS.',
            'end.after' => 'Время окончания должно быть позже времени начала.',
        ];
    }
}
