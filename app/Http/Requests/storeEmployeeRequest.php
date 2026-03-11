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
            'full_name' => 'required|string',
            'nip' => 'required|string',
            'employee_type_id' => 'required|integer',
            'work_unit_id' => 'required|integer',
            'position_id' => 'required|integer',
            'email' => 'required|email',
            'phone' => 'required|string',
            'is_active' => 'required|boolean'
        ];
    }
}