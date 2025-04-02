<?php

namespace App\Http\Resources\Api\Purchase;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseBookResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => Helper::generateImageUrl($this->image),
        ];
    }
}
