<?php

namespace App\Http\Resources\Api;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tracking_code' => $this->tracking_code,
            'paid_amount' => $this->paid_amount,
            'gateway_name' => $this->gateway_name,
            'discount_percent' => $this->id,
            'status' => $this->status,
            'date' => Helper::gregorianToShamsi($this->created_at),
            'books' => PaymentBookResource::collection($this?->books ?: [])
        ];
    }
}
