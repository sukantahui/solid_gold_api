<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'customerId' => $this->id,
            'category' => [
                'customerCategoryId' => $this->customer_category_id,
                'name' => $this->category->customer_category_name ?? null,
            ],
            'customerName' => $this->customer_name,
            'mailingName' => $this->mailing_name,
            'contact' => [
                'email' => $this->email,
                'phone' => $this->phone,
                'mobile1' => $this->mobile1,
                'mobile2' => $this->mobile2,
                'whatsapp' => $this->whatsapp,
                'address' => $this->address,
                'pinCode' => $this->pin_code,
            ],
            'balances' => [
                'gold' => (float)$this->opening_gold_balance,
                'cash' => (float)$this->opening_cash_balance,
            ],
            'status' => $this->getStatusAttributes(),
            'timestamps' => $this->getTimestamps(),
        ];
    }
    /**
     * Get formatted status attributes
     */
    protected function getStatusAttributes(): array
    {
        return [
            'active' => (bool)$this->active,
            'orderActive' => (bool)$this->order_active,
            'billActive' => (bool)$this->bill_active,
            'jobActive' => (bool)$this->job_active,
            'inforce' => (bool)$this->inforce,
        ];
    }

    /**
     * Get formatted timestamps with null check
     */
    protected function getTimestamps(): array
    {
        return [
            'createdAt' => $this->created_at?->format('d/m/Y H:i:s'),
            'updatedAt' => $this->updated_at?->format('d/m/Y H:i:s'),
        ];
    }
}
