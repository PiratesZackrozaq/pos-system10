<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'product_name' => $this->product->name,
            'price' => $this->price,
            'quantity' => $this->quantity,
        ];
    }
}
