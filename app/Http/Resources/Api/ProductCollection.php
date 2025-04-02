<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(function ($item) {
                return [
                    'id' => $item->id,
                    'type' => $item->type,
                    'name' => $item->name,
                    'image' => $item->getImage(),
                    'author' => $item->author->name,
                    'publisher' => $item->publisher->name,
                    'speaker' => $item->speaker?->name,
                    'translator' => $item->translator?->name,
                    'time' => $item->time,
                    'price' => $item->price,
                    'discount_price' => $item->discount_price,
                    'comment_count' => count($item->comments),
                    'categories' => $item->categories,
                    'content' => $item->content,
                ];
            }),
        ];
    }


}
