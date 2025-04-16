<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StoreGoldTransactionRequest extends FormRequest
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
                'transactionDate' => 'required|date',
                'customerId' => 'required|exists:customers,id',
                'agentId' => 'required|exists:agents,id',
                'orderMasterId' => 'required|exists:order_masters,id',
                'goldValue' => [
                    'required',
                    'numeric',
                    'min:0',
                    'regex:/^\d+(\.\d{1,3})?$/' // Ensures max 3 decimal places
                ],
                'goldRate' => 'required|integer|min:0',
                'goldCash' => 'required|integer|min:0',
                'transactionTypeId' => 'required|exists:transaction_types,id',
                'inforce' => 'sometimes|boolean'
        ];
    }
}
