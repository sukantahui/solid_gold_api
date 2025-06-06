<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ConvertsCamelToSnake;

class StorePriceCodeRequest extends FormRequest
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
        return [
            'price_code_name' => 'required|string|max:2|unique:price_codes,price_code_name',
        ];
    }
    protected function prepareForValidation()
    {
        // Convert camelCase to snake_case before validation
        $this->merge($this->convertCamelToSnake($this->all()));
        // Ensure inforce has a default value if not set
        if (!$this->has('inforce')) {
            $this->merge(['inforce' => true]);
        }
    }
}
