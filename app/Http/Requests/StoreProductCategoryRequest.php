<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'productCategoryName' => [
                'required',
                'string',
                'max:255',
                Rule::unique('product_categories', 'product_category_name')
            ],
            'productCategoryDescription' => [
                'nullable',
                'string',
                'max:1000'
            ],
        ];
    }

    public function messages()
    {
        return [
            'productCategoryName.required' => 'The category name is required',
            'productCategoryName.string' => 'The category name must be text',
            'productCategoryName.max' => 'The category name cannot exceed 255 characters',
            'productCategoryName.unique' => 'This category name already exists',
            'productCategoryDescription.string' => 'The description must be text',
            'productCategoryDescription.max' => 'The description cannot exceed 1000 characters',
        ];
    }
}
