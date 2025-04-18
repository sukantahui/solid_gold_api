<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ConvertsCamelToSnake;

class StoreTransactionTypeRequest extends FormRequest
{
    use ConvertsCamelToSnake;
    public function authorize(): bool
    {
        // Add authorization logic here, if needed
        return true;
    }

    public function rules(): array
    {
        return [
            'transaction_type_name' => 'required|string|max:255|unique:transaction_types,transaction_type_name',
            'inforce' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'transactionTypeName.required' => 'The transaction type name is required.',
            'transactionTypeName.string' => 'The transaction type name must be a valid string.',
            'transactionTypeName.max' => 'The transaction type name must not exceed 255 characters.',
            'transactionTypeName.unique' => 'This transaction type name is already in use.',
            'inforce.boolean' => 'The inforce field must be true or false.',
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
