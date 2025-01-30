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
        return [
            'name' => ['string', 'max:255'],
            'email' => [ 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['string', 'min:8'],
            'phone' => 'numeric|digits_between:10,15',
            'address' => 'string|max:500',
            'bank' => 'string|max:255',
            'accountno' => 'nullable',
            'salary' => 'nullable',
        ];
    }
}
