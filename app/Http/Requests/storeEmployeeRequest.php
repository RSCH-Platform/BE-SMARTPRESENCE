<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'full_name' => 'required',
            'nip' => 'required|unique:employees',
            'employee_type_id' => 'required|exists:employee_types,id',
            'work_unit_id' => 'required|exists:work_units,id',
            'position_id' => 'required|exists:positions,id',
            'email' => 'required|email|unique:employees',
            'phone' => 'nullable',
            'signature_path' => 'nullable',
            'is_active' => 'boolean'
        ];
    }
}