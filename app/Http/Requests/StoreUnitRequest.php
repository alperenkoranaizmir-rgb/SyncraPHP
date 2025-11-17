<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreUnitRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        return [
            'block' => 'nullable|string|max:50',
            'ada' => 'nullable|string|max:50',
            'parsel' => 'nullable|string|max:50',
            'unit_no' => 'required|string|max:100',
            'unit_type' => 'nullable|string|max:100',
            'floor' => 'nullable|string|max:10',
            'area_m2' => 'nullable|numeric',
            'arsa_payi_num' => 'nullable|integer',
            'arsa_payi_den' => 'nullable|integer',
            'tapu_raw_json' => 'nullable|json',
            'usage_status' => 'nullable|string',
        ];
    }
}
