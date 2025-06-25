<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return array_filter([
            'productId'            => (int) $this->product_id,
            'productName'          => $this->product_name,
            'productNumber'        => $this->product_number,
            'productCategoryId'    => $this->product_category_id !== null ? (int) $this->product_category_id : null,
            'priceCodeName'        => $this->price_code_name,
            'priceCodeId'          => $this->price_code_id !== null ? (int) $this->price_code_id : null,
            'productCategoryName'  => $this->product_category_name,
            'wastegePercentage'    => $this->wastege_percentage !== null ? (float) $this->wastege_percentage : null,
            'labourCharge'         => $this->labour_charge !== null ? (float) $this->labour_charge : null,
        ], fn($value) => $value !== null);
    }
}
