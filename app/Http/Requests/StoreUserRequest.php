<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // policy will handle more complex checks
    }

    public function rules(): array
    {
        $userId = $this->route('user')?->id ?? null;

        return [
            'ad' => ['required','string','max:191'],
            'soyad' => ['required','string','max:191'],
            'tc_kimlik_no' => ['nullable','string','max:20','unique:users,tc_kimlik_no,'.$userId],
            'email' => ['required','email','unique:users,email,'.$userId],
            'password' => [$userId ? 'nullable' : 'required','string','min:6'],
            'telefon' => ['nullable','string','max:30'],
            'profil_resmi' => ['nullable','file','image','max:10240'],
            'saglik_engeli_varmi' => ['sometimes','boolean'],
            'saglik_raporu' => ['nullable','file','required_if:saglik_engeli_varmi,1'],
        ];
    }
}
