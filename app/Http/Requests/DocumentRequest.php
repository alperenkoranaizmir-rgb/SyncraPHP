<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'unit_id' => 'nullable|exists:units,id',
            'owner_id' => 'nullable|exists:owners,id',
            'agreement_id' => 'nullable|exists:agreements,id',
            'doc_type' => 'nullable|string|max:100',
            'file' => 'nullable|file|max:10240',
        ];
    }
}
