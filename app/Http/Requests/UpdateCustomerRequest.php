<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
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
        'customerCategoryId' => 'required|integer|exists:customer_categories,id',
        'customerName' => [
            'required',
            'string',
            'max:255',
            Rule::unique('customers', 'customer_name')->ignore($this->route('id')) // Correct ignore method
        ],
        'email' => [
            'required',
            'email',
            'max:255',
            Rule::unique('customers', 'email')->ignore(2)
        ],
        'phone' => [
            'required',
            'string',
            'max:20',
            'regex:/^[0-9\-]+$/',
            Rule::unique('customers', 'phone')->ignore($this->route('id'))
        ],
        'mobile1' => ['nullable', 'string', 'max:15', 'regex:/^[0-9\-]+$/'],
        'mobile2' => ['nullable', 'string', 'max:15', 'regex:/^[0-9\-]+$/'],
        'whatsapp' => ['nullable', 'string', 'max:15', 'regex:/^[0-9\-]+$/'],
        'address' => 'required|string|max:500',
        'pinCode' => 'required|string|max:10',
        'openingGoldBalance' => 'nullable|numeric|min:0',
        'openingCashBalance' => 'nullable|numeric|min:0',
        'active' => 'boolean',
        'orderActive' => 'boolean',
        'billActive' => 'boolean',
        'jobActive' => 'boolean',
        'inforce' => 'boolean',
    ];
}

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $phone = $this->input('phone');
            $mobile1 = $this->input('mobile1');
            $mobile2 = $this->input('mobile2');

            if (($phone && $phone === $mobile1) || ($phone && $phone === $mobile2) || ($mobile1 && $mobile1 === $mobile2)) {
                $validator->errors()->add('phone', 'Phone, Mobile 1, and Mobile 2 must be unique within the same record.');
                $validator->errors()->add('mobile1', 'Phone, Mobile 1, and Mobile 2 must be unique within the same record.');
                $validator->errors()->add('mobile2', 'Phone, Mobile 1, and Mobile 2 must be unique within the same record.');
            }
        });
    }

    public function messages(): array
    {
        return [
            'customerCategoryId.exists' => 'The selected customer category does not exist.',
            'customerName.unique' => 'This customer name is already taken.',
            'email.unique' => 'This email is already registered.',
            'phone.unique' => 'This phone number is already in use.',
            'mobile1.unique' => 'This mobile1 number is already in use.',
            'mobile2.unique' => 'This mobile2 number is already in use.',
            'whatsapp.unique' => 'This WhatsApp number is already in use.',
            'phone.regex' => 'The phone number format is invalid.',
            'mobile1.regex' => 'The mobile1 number format is invalid.',
            'mobile2.regex' => 'The mobile2 number format is invalid.',
            'whatsapp.regex' => 'The WhatsApp number format is invalid.',
        ];
    }

}
