<?php

namespace App\Http\Resources\Api;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $product = $this->product;

        return [
            'id' => $this->id,
            'name' => $product?->name,
            'type' => $product?->type,
            'image' => Helper::generateImageUrl($product->image),
            'author_names' => $product?->productAuthors?->pluck('name'),
            'publisher_name' => $product?->publisher?->name,
            'rate' => $this->rate ?: 0
        ];

    }
}
