<?php

namespace App\Http\Requests\Product;

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
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'cabin' => 'required|numeric',
            'length' => 'required|numeric',
            'speed' => 'required|numeric',
            'crew' => 'required|numeric',
            'beam' => 'required|numeric',
            'year' => 'required|numeric',
            'builder' => 'required|string',
        ];
    }
}
