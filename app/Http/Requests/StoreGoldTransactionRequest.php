<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ConvertsCamelToSnake;

class StoreGoldTransactionRequest extends FormRequest
{
    use ConvertsCamelToSnake;
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // Rules using snake_case (database) field names
        return [
            'transaction_date' => 'required|date|before_or_equal:today',
            'customer_id' => [
                'required',
                Rule::exists('customers', 'id')->where('active', true)
            ],
            'agent_id' => [
                'required',
                Rule::exists('agents', 'id')->where('active', true)
            ],
            'order_master_id' => 'nullable|exists:order_masters,id',
            'gold_value' => 'required|numeric|min:0.001|max:9999999.999',
            'gold_rate' => [
                'nullable',
                'integer',
                'min:1',
                Rule::requiredIf(function () {
                    return $this->input('transaction_type_id') == 3 ;
                })
            ],
            'gold_cash' => [
                'nullable',
                'integer',
                'min:0',
                Rule::requiredIf(function () {
                    return $this->input('transaction_type_id') == 3 ;
                })
            ],
            'transaction_type_id' => [
                'required',
                Rule::exists('transaction_types', 'id')->where('inforce', true)
            ],
            'inforce' => 'sometimes|boolean'
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

        // $this->merge([
        //     'transaction_date' => $this->transactionDate ?? $this->transaction_date,
        //     'customer_id' => $this->customerId ?? $this->customer_id,
        //     'agent_id' => $this->agentId ?? $this->agent_id,
        //     'order_master_id' => $this->orderMasterId ?? $this->order_master_id,
        //     'gold_value' => $this->goldValue ?? $this->gold_value,
        //     'gold_rate' => $this->goldRate ?? $this->gold_rate,
        //     'gold_cash' => $this->goldCash ?? $this->gold_cash,
        //     'transaction_type_id' => $this->transactionTypeId ?? $this->transaction_type_id
        // ]);
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $transactionTypeId = $this->input('transaction_type_id');
            $goldRate = $this->input('gold_rate');
            $goldCash = $this->input('gold_cash');
            $goldValue = $this->input('gold_value');

            if ($transactionTypeId == 3) {
                if (is_null($goldRate)) {
                    $validator->errors()->add('goldRate', 'Gold rate is required for this transaction type');
                }
                if (is_null($goldCash)) {
                    $validator->errors()->add('goldCash', 'Gold cash is required for this transaction type');
                }
            }

            if ($transactionTypeId==3 && $goldRate && $goldCash) {
                $expectedCash = $goldValue * ($goldRate / 10);
                if (abs($goldCash - $expectedCash) > 100) {
                    $validator->errors()->add(
                        'goldCash',
                        'Cash value should be approximately ' . number_format($expectedCash)
                    );
                }
            }
        });
    }

    public function messages()
    {
        return [
            'gold_rate.required_if' => 'Gold rate is required for this transaction type',
            'gold_cash.required_if' => 'Gold cash is required for this transaction type',
            'transaction_date.before_or_equal' => 'Transaction date cannot be in the future',
            'gold_value.min' => 'Gold value must be at least 0.001 grams'
        ];
    }
}
