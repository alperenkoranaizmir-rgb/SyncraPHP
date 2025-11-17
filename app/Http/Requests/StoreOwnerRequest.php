<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOwnerRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string|max:150',
            'last_name' => 'required|string|max:150',
            'tc_no' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'birth_date' => 'nullable|date',
            'disability_flag' => 'sometimes|boolean',
            'disability_report' => 'required_if:disability_flag,1|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'photo' => 'nullable|image|max:2048'
        ];
    }
}
