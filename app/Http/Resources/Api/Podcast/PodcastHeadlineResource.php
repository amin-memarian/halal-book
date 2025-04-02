<?php

namespace App\Http\Resources\Api\Podcast;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PodcastHeadlineResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'time' => $this->time,
            'file' => $this?->file ? Helper::generateFileUrl($this->file) : '',
            'order_no' => $this->order_number
        ];
    }
}
