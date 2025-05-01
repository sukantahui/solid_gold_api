<?php

namespace App\Http\Requests;

use App\Traits\ConvertsCamelToSnake;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductCategoryRequest extends FormRequest
{
    use ConvertsCamelToSnake;
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
            'product_category_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('product_categories', 'product_category_name')
            ],
            'product_category_description' => [
                'nullable',
                'string',
                'max:1000'
            ],
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
