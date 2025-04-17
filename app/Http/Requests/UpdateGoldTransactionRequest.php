<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGoldTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'transactionDate' => 'nullable|date',
            'customerId' => 'required|exists:customers,id',
            'agentId' => 'required|exists:agents,id',
            'orderMasterId' => 'nullable|exists:order_masters,id',
            'goldValue' => 'required|numeric|min:0',
            'goldRate' => 'nullable|integer|min:0',
            'goldCash' => 'nullable|integer|min:0',
            'transactionTypeId' => 'required|exists:transaction_types,id',
            'inforce' => 'boolean',
        ];
    }

    public function prepareForValidation()
    {
        // Convert camelCase input to snake_case for model compatibility
        $this->merge([
            'transaction_date' => $this->transactionDate,
            'customer_id' => $this->customerId,
            'agent_id' => $this->agentId,
            'order_master_id' => $this->orderMasterId,
            'gold_value' => $this->goldValue,
            'gold_rate' => $this->goldRate,
            'gold_cash' => $this->goldCash,
            'transaction_type_id' => $this->transactionTypeId,
        ]);
    }
}
