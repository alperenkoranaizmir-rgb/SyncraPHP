<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OwnerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'tc_no' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'phone_primary' => 'nullable|string|max:50',
            'address' => 'nullable|string',
        ];
    }
}
