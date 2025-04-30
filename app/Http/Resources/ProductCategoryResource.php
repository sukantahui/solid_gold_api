<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ProductCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'productCategoryId' => $this->id,
            'categoryName' => $this->product_category_name,
            'description' => $this->product_category_description,
            'isInforce' => $this->inforce,
            'createdAt' => Carbon::parse($this->created_at)->format('d-m-Y H:i:s'),
            'updatedAt' => Carbon::parse($this->updated_at)->format('d-m-Y H:i:s'),
            // Relationships (uncomment if needed)
            'productsCount' => $this->whenCounted('products', function () {
                return $this->products_count;
            }),
        ];
    }
}
