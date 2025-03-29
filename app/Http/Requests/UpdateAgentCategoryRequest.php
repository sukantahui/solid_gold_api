<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAgentCategoryRequest extends FormRequest
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
    public function rules()
    {
        return [
            'customerCategoryName' => [
                'required',
                'string',
                'max:255',
                Rule::unique('customer_categories')->ignore($this->route('id'))
            ],

            // If you need to include other fields later:
            // 'status' => 'sometimes|boolean',
            // 'description' => 'nullable|string|max:500'
        ];
    }
    public function messages()
    {
        return [
            'customer_category_name.required' => 'The category name is required.',
            'customer_category_name.string' => 'The category name must be a string.',
            'customer_category_name.max' => 'The category name may not be greater than 255 characters.',
            'customer_category_name.unique' => 'This category name already exists.',
        ];
    }
}
