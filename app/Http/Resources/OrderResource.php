<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customer' => [
                'name' => $this->customer->name,
                'phone' => $this->customer->phone,
            ],
            'invoice_no' => $this->invoice_no,
            'tracking_no' => $this->tracking_no,
            'total_amount' => $this->total_amount,
            'order_date' => $this->order_date,
            'payment_mode' => $this->payment_mode,
            'order_status' => $this->order_status,
            'order_items' => OrderItemResource::collection($this->orderItems),
        ];
    }
}
