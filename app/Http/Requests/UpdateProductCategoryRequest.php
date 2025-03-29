<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateProductCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Change this if you need authorization
    }

    public function rules()
    {
        return [
            'productCategoryName' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('product_categories', 'product_category_name')
                    ->ignore($this->id)
            ],
            'productCategoryDescription' => 'nullable|string|max:1000',
            'inforce' => 'sometimes|boolean',
        ];
    }

    public function messages()
{
    return [
        // Category Name messages
        'productCategoryName.required' => 'A category name is required for update',
        'productCategoryName.string' => 'Category name must be a valid text string',
        'productCategoryName.max' => 'Category name cannot be longer than 255 characters',
        'productCategoryName.unique' => 'This category name is already being used by another category',

        // Description messages
        'productCategoryDescription.string' => 'Description must be in text format',
        'productCategoryDescription.max' => 'Description cannot exceed 1000 characters',

        // Status messages
        'inforce.boolean' => 'Active status must be either true or false',
        'inforce.required' => 'Active status is required for update',
    ];
}
}
