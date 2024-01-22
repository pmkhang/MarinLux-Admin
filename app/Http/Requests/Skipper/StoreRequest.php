<?php

namespace App\Http\Requests\Skipper;

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
            'name'=>'required|string|unique:skippers,name',
            'email'=>'required|email|unique:skippers,email',
            'phone'=>'required|numeric',
        ];
    }

    public function messages()
    {
        return[
            'name.required'=>'Please enter a name.',
            'name.string'=>'The name must be a string.',
            'name.unique'=>'The name has already been taken.',
            'name.max'=>'The name must not exceed :max characters.',
            'email.required'=>'Please enter a email.',
            'email.string'=>'The email must be a string.',
            'email.unique'=>'The email has already been taken.',
            'email.max'=>'The email must not exceed :max characters.',
            'phone.required'=>'Please enter a phone number.',
            'phone.numeric'=>'The phone number must be a number.',
            'phone.max'=>'The phone number must not exceed.',

        ];
    }


}
