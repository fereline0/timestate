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
            'begin' => 'required|date_format:H:i:s',
            'end' => 'required|date_format:H:i:s|after:begin',
        ];
    }
}
