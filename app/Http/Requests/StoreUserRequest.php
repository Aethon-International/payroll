<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'phone' => 'numeric|digits_between:10,15',
            'address' => 'string|max:500',
            'bank' => 'string|max:255',
            'accountno' => 'nullable',
            'salary' => 'nullable',
        ];
    }
   /**
     * Get custom messages for validation errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.unique' => 'This email has already been taken.',
            // Add other custom messages if needed
        ];
    }
}
