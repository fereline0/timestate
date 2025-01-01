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
}
