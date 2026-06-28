<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            /**
             * NIP (Nomor Induk Pegawai)
             * @example 198001012005011001
             */
            'nip' => 'required|string',
            
            /**
             * Password pengguna
             * @example password123
             */
            'password' => 'required|string'
        ];
    }
}