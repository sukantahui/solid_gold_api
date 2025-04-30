<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePriceCodeRequest extends FormRequest
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
            'price_code_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('price_codes')->ignore($this->route('id')) // For route model binding
                // If using ID parameter instead, use:
                // Rule::unique('price_codes')->ignore($this->route('id'))
            ],
            'inforce' => [
                'sometimes', // The field is optional
                'boolean'
            ]
        ];
    }
}
