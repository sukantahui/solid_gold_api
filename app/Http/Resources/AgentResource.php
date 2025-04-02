<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgentResource extends JsonResource
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
            'agentCategoryId' => $this->agent_category_id,
            'agentName' => $this->agent_name,
            'shortName' => $this->short_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'pinCode' => $this->pin_code,
            'active' => (bool) $this->active,
            'inforce' => (bool) $this->inforce,
            'createdAt' => $this->created_at?$this->created_at->format('Y-m-d H:i:s'):null,
            'updatedAt' => $this->updated_at?$this->updated_at->format('Y-m-d H:i:s'):null,
            'category' => new AgentCategoryResource($this->whenLoaded('agentCategory')),
        ];
    }
}
