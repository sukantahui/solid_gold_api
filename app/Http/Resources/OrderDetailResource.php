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
            'orderDetailId' => $this->id,
            'orderMasterId' => $this->order_master_id,
            'productId' => $this->product_id,
            'quantity' => $this->quantity,
            'gini' => (float) $this->gini,
            'wastegePercentage' => (float) $this->wastege_percentage,
            'productSize' => $this->product_size,
            'createdAt' => $this->created_at?$this->created_at->format('Y-m-d H:i:s'):null,
            'updatedAt' => $this->updated_at?$this->updated_at->format('Y-m-d H:i:s'):null,
        ];
    }
}
