<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'type' => $this->type,
            'name' => $this->name,
            'image' => $this->getImage(),
            'authors' => AuthorResource::collection($this->authors),
            'publisher' => $this->publisher?->name,
            'speaker' => $this->speaker?->name,
            'translator' => $this->translator?->name,
            'time' => $this->time,
            'price' => $this->price,
            'discount_price' => $this->discount_price,
            'categories' => CategoryResource::collection($this->categories),
            'content' => $this->content,

            'comments' => CommentResource::collection($this->comments),
            'comment_count' => count($this->comments),
        ];
    }
}
