<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            ],
            'password_confirmation' => 'required|same:password',
            'name' => 'required',
            'phone' => 'required|numeric|digits:10|unique:users,phone,',
        ];
    }
    public function messages(): array
    {
        return [
            'email.required' => 'Please enter an email address !',
            'email.unique' => 'Email already exists. Please choose a different email !',
            'email.email' => 'Please enter a valid email address !',
            'password.required' => 'Please enter a password !',
            'password.confirmed' => 'Password confirmation does not match !',
            'password_confirmation.same' => 'Password confirmation does not match !',
            'password.min' => 'Password must be at least 8 characters long !',
            'password.regex' => 'Password must contain at least one lowercase letter, one uppercase letter, one digit, and one special character (a-z, A-Z, 0-9, !-*) !',
            'name.required' => 'Please enter name !',
            'phone.required' => 'Please enter phone !',
            'phone.numeric' => 'Phone must be a number !',
            'phone.digits' => 'Phone must be max 10 digits !',
        ];
    }
}
