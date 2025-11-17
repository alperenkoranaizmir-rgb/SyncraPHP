<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgreementRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'unit_id' => 'nullable|exists:units,id',
            'status' => 'nullable|string|max:50',
            'meeting_date' => 'nullable|date',
            'met_person_name' => 'nullable|string|max:191',
            'notes' => 'nullable|string',
        ];
    }
}
