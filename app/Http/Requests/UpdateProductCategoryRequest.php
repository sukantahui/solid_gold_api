<?php

namespace App\Http\Requests;

use App\Traits\ConvertsCamelToSnake;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator; 

class UpdateProductCategoryRequest extends FormRequest
{
    use ConvertsCamelToSnake;
    public function authorize()
    {
        return true; // Change this if you need authorization
    }

    public function rules()
    {
        $productCategoryId = $this->route('productCategoryId');

        // First validate that the ID exists
        Validator::make(
            ['productCategoryId' => $productCategoryId], 
            ['productCategoryId' => 'required|exists:product_categories,id']
        )->validate();
        
        return [
            'product_category_name' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('product_categories', 'product_category_name')
                    ->ignore($productCategoryId)
            ],
            'product_category_cescription' => 'nullable|string|max:1000',
            'inforce' => 'sometimes|boolean',
        ];
    }

    public function prepareForValidation()
    {
        // Automatically convert all camelCase inputs to snake_case
        $this->merge($this->convertCamelToSnake($this->all()));

        // Ensure inforce has a default value if not set
        if (!$this->has('inforce')) {
            $this->merge(['inforce' => true]);
        }
    }

    public function messages()
{
    return [
        // Category Name messages
        'product_category_name.required' => 'A category name is required for update',
        'product_category_name.string' => 'Category name must be a valid text string',
        'product_category_name.max' => 'Category name cannot be longer than 255 characters',
        'product_category_name.unique' => 'This category name is already being used by another category',

        // Description messages
        'product_category_cescription.string' => 'Description must be in text format',
        'product_category_cescription.max' => 'Description cannot exceed 1000 characters',

        // Status messages
        'inforce.boolean' => 'Active status must be either true or false',
        'inforce.required' => 'Active status is required for update',
    ];
}
}
