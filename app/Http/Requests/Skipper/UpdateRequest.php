<?php

namespace App\Http\Requests\Skipper;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name' => 'required|string|unique:skippers,name,' . $this->id,
            'email' => 'required|email|unique:skippers,email,' . $this->id,
            'phone' => 'required|numeric',
        ];
    }


    public function message()
    {
        return [
            'name.required' => 'Please enter a name.',
            'name.string' => 'The name must be a string.',
            'name.unique' => 'The name has already been taken.',
            'name.max' => 'The name must not exceed :max characters.',
            'phone.required' => 'Please enter a phone number.',
            'phone.numeric' => 'The phone number must be a number.',
        ];
    }
}
