<?php

namespace App\Http\Resources\Api\Cart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookCategoryResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            $this->title
        ];
    }
}
