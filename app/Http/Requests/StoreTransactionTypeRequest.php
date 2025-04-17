<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Add authorization logic here, if needed
        return true;
    }

    public function rules(): array
    {
        return [
            'transactionTypeName' => 'required|string|max:255|unique:transaction_types,transaction_type_name',
            'inforce' => 'nullable|boolean',  // Optional, defaults to true if not set
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
        // Convert camelCase to snake_case for database compatibility
        $this->merge([
            'transaction_type_name' => $this->transactionTypeName,
            'inforce' => $this->inforce ?? true,  // Default to true if not provided
        ]);
    }
}
