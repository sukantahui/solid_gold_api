<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

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
            'customerCategoryId' => 'required|integer|exists:customer_categories,id',
            'customerName' => 'required|string|max:255|unique:customers,customer_name',
            'mailingName' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customers,email',
            'phone' => 'required|string|max:20|regex:/^[0-9\-]+$/|unique:customers,phone',
            'mobile1' => 'string|max:15|regex:/^[0-9\-]+$/',
            'mobile2' => 'string|max:15|regex:/^[0-9\-]+$/',
            'whatsapp' => 'string|max:15|regex:/^[0-9\-]+$/',
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

    /**
     * Additional validation to ensure phone, mobile1, and mobile2 are unique.
     */
    public function withValidator($validator) // ✅ Remove type declaration
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
            'customerCategoryId.required' => 'The customer category is required.',
            'customerCategoryId.integer' => 'The customer category must be a valid numeric ID.',
            'customerCategoryId.exists' => 'The selected customer category does not exist.',

            'customerName.required' => 'The customer name is required.',
            'customerName.string' => 'The customer name must be a valid text.',
            'customerName.max' => 'The customer name cannot exceed 255 characters.',
            'customerName.unique' => 'This customer name is already in use.',

            'mailingName.required' => 'The mailing name is required.',
            'mailingName.string' => 'The mailing name must be valid text.',
            'mailingName.max' => 'The mailing name cannot exceed 255 characters.',

            'email.required' => 'An email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.max' => 'The email address cannot exceed 255 characters.',
            'email.unique' => 'This email is already associated with another customer.',

            'phone.required' => 'A phone number is required.',
            'phone.string' => 'The phone number must be valid text.',
            'phone.max' => 'The phone number cannot exceed 20 characters.',
            'phone.regex' => 'The phone number format is invalid. Only numbers and dashes are allowed.',
            'phone.unique' => 'This phone number is already in use.',

            'mobile1.string' => 'The mobile number must be valid text.',
            'mobile1.max' => 'The mobile number cannot exceed 15 characters.',
            'mobile1.regex' => 'The mobile number format is invalid. Only numbers and dashes are allowed.',

            'whatsapp.string' => 'The WhatsApp number must be valid text.',
            'whatsapp.max' => 'The WhatsApp number cannot exceed 15 characters.',
            'whatsapp.regex' => 'The WhatsApp number format is invalid. Only numbers and dashes are allowed.',

            'address.required' => 'The address is required.',
            'address.string' => 'The address must be valid text.',
            'address.max' => 'The address cannot exceed 500 characters.',

            'pinCode.required' => 'The pin code is required.',
            'pinCode.string' => 'The pin code must be valid text.',
            'pinCode.max' => 'The pin code cannot exceed 10 characters.',

            'openingGoldBalance.numeric' => 'The opening gold balance must be a valid number.',
            'openingGoldBalance.min' => 'The opening gold balance cannot be negative.',

            'openingCashBalance.numeric' => 'The opening cash balance must be a valid number.',
            'openingCashBalance.min' => 'The opening cash balance cannot be negative.',

            'active.boolean' => 'The active status must be either true or false.',
            'orderActive.boolean' => 'The order active status must be either true or false.',
            'billActive.boolean' => 'The bill active status must be either true or false.',
            'jobActive.boolean' => 'The job active status must be either true or false.',
            'inforce.boolean' => 'The inforce status must be either true or false.',
        ];
    }
}
