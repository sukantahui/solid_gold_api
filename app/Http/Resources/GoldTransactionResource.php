<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GoldTransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'transactionDate' => $this->transaction_date->toDateString(),
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'agent' => new AgentResource($this->whenLoaded('agent')),
            'orderMaster' => new OrderResource($this->whenLoaded('orderMaster')),
            'transactionType' =>new TransactiontypeResource($this->whenLoaded('transactionType')),
            'goldValue' => $this->gold_value,
            'goldRate' => $this->gold_rate,
            'goldCash' => $this->gold_cash,
            'inforce' => $this->inforce,
            'createdAt' => $this->created_at?->toDateTimeString(),
            'updatedAt' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
