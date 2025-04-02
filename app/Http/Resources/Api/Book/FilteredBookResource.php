<?php

namespace App\Http\Resources\Api\Book;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FilteredBookResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => Helper::generateImageUrl($this->image),
            'type' => $this->type,
            'price' => $this->price,
            'discount_price' => $this->discount_price,
            'rate' => $this->calculateAverageRate(),
        ];
    }

    private function calculateAverageRate(): float
    {
        $totalRates = $this->comments->sum('rate');
        $countRates = $this->comments->count();

        if ($countRates === 0)
            return 0;

        return $totalRates / $countRates;
    }

}
