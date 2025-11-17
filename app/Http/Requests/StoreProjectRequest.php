<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreProjectRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'location_json' => 'nullable|json',
            'type' => 'nullable|string|max:100',
            'status' => 'nullable|string',
            'total_units' => 'nullable|integer|min:0',
            'total_m2' => 'nullable|numeric',
            'construction_area' => 'nullable|numeric',
            'start_date' => 'nullable|date',
            'est_end_date' => 'nullable|date',
            'est_budget' => 'nullable|numeric',
            'emsal_ratio' => 'nullable|numeric',
        ];
    }
}
