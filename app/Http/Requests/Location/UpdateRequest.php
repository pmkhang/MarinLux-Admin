<?php

namespace App\Http\Requests\Location;

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
            'name' => 'required|string|unique:locations,name,' . $this->id,
        ];
    }

    public function messages()
    {
        return
        [
            'name.required'=>'Please enter a Loaction',
            'name.string'=>'The name must be a string.',
            'name.unique'=>'The name has already been taken.',
        ];
    }

}
