<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order_no' => $this->order_no,
            'store_id' => $this->store_id,
            'customer_name' => $this->customer_name,
            'status' => $this->status,
            'total_items' => $this->total_items,
            'total_qty' => $this->total_qty,
            'items' => OrderItemResource::collection($this->whenLoaded('items')),
            'created_at' => $this->created_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
