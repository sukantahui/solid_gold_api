<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
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
            'orderMaster.customerId' => [
                'required',
                'integer',
                Rule::exists('customers', 'id'),
            ],
            'orderMaster.agentId' => [
                'required',
                'integer',
                Rule::exists('agents', 'id'),
            ],
            'orderDetails' => 'required|array'
        ];
    }
}
