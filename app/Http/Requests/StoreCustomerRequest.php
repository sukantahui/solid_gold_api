<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
            'customerCategoryId' => 'required|integer||exists:customer_categories,id',
            'customerName' => 'required|string|max:255|unique:customers,customer_name',
            'mailingName' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customers,email',
            'phone' => 'required|string|max:20|regex:/^[0-9\-]+$/',
            'address' => 'required|string|max:500',
            'pinCode' => 'required|string|max:10',
            'openingGoldBalance' => 'nullable|numeric|min:0',
            'openingCashBalance' => 'nullable|numeric|min:0',
            'active' => 'boolean',
            'orderActive' => 'boolean',
            'billActive' => 'boolean',
            'jobCctive' => 'boolean',
            'inforce' => 'boolean',
        ];
    }
}
