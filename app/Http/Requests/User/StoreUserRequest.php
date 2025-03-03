<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Adjust based on your authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024', // Adjusted to allow specific image types
            'name' => 'required|string|max:255', // Extended the max length to 255
            'email' => 'required|email|max:255|unique:users,email', // Extended the max length to 255
            'password' => [
                'required',
                'string',
                'min:8', // Minimum length of 8 characters
                'regex:/[0-9]/', // Must contain at least one number
                'regex:/[!@#$%^&*(),.?":{}|<>]/', // Must contain at least one special character
                'confirmed',
            ],
            'password_confirmation' => 'required_with:password|string|min:8', // Ensured it's required if password is present
        ];
    }
}
