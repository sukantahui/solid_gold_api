<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'orderMasterId' => $this->order_master_id,
            'productId' => $this->product_id,
            'quantity' => $this->quantity,
            'gini' => (float) $this->gini,
            'wastegePercentage' => (float) $this->wastege_percentage,
            'productSize' => $this->product_size,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
