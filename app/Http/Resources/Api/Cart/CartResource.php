<?php

namespace App\Http\Resources\Api\Cart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{

    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'price' => $this->price,
            'discount_price' => $this->discount_price ?: 0,
            'type' => $this->type,
            'quantity' => $this->pivot->quantity,
            'categories' => BookCategoryResource::collection($this?->categories ?: []),
        ];
    }
}
