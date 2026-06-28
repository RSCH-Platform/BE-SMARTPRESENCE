<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $userId = $this->route('id');

        return [
            'name' => 'sometimes|required|string|max:100',
            'email' => 'nullable|email|max:100|unique:users,email,' . $userId,
            'nip' => 'sometimes|required|string|max:50|unique:users,nip,' . $userId,
            'password' => 'nullable|string|min:8',
            'roles' => 'sometimes|required|array',
            'roles.*' => 'integer|exists:roles,id|not_in:1',
        ];
    }
}
