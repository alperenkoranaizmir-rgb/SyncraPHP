<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'block' => 'nullable|string|max:50',
            'ada' => 'nullable|string|max:50',
            'parsel' => 'nullable|string|max:50',
            'unit_no' => 'required|string|max:50',
            'unit_type' => 'nullable|string|max:50',
            'floor' => 'nullable|integer',
            'area_m2' => 'nullable|numeric',
            'usage_status' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ];
    }
}
