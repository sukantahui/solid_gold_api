<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'orderNumber' => $this->order_number,
            // 'customerId' => $this->customer_id,
            // 'agentId' => $this->agent_id,
            'orderNote' => $this->order_note,
            'orderDate' => $this->order_date,
            // 'employeeId' => $this->employee_id,
            'createdAt' => $this->created_at?$this->created_at->format('Y-m-d H:i:s'):null,
            'updatedAt' => $this->updated_at?$this->updated_at->format('Y-m-d H:i:s'):null,
        
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'agent' => new AgentResource($this->whenLoaded('agent')),
            'employee' => new EmployeeResource($this->whenLoaded('employee')),
            'orderDetails' => OrderDetailResource::collection($this->whenLoaded('orderDetails')),
        ];
    }
}
