<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator; 

use App\Traits\ConvertsCamelToSnake;

class UpdatePriceCodeRequest extends FormRequest
{
    use ConvertsCamelToSnake;
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
        $priceCodeId = $this->route('priceCodeId');

        // First validate that the ID exists
        Validator::make(
            ['priceCodeId' => $priceCodeId], 
            ['priceCodeId' => 'required|exists:price_codes,id']
        )->validate();

        return [
            'price_code_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('price_codes')->ignore($this->route('priceCodeId')) // For route model binding
                // If using ID parameter instead, use:
                // Rule::unique('price_codes')->ignore($this->route('id'))
            ],
            'priceCodeId' =>['required|exists:price_codes,id'],
            'inforce' => [
                'sometimes', // The field is optional
                'boolean'
            ]
        ];
    }

    public function prepareForValidation()
    {
        // Automatically convert all camelCase inputs to snake_case
        $this->merge($this->convertCamelToSnake($this->all()));

        // Ensure inforce has a default value if not set
        if (!$this->has('inforce')) {
            $this->merge(['inforce' => true]);
        }
    }
}
