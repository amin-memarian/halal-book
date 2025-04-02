<?php

namespace App\Http\Resources\Api\Purchase;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tracking_code' => $this->tracking_code,
            'date' => Helper::gregorianToShamsi($this->created_at),
            'status' => $this->status,
            'books' => PurchaseBookResource::collection($this->books)
        ];
    }
}
