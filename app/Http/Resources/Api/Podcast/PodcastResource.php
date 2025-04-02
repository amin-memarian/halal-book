<?php

namespace App\Http\Resources\Api\Podcast;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PodcastResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => Helper::generateImageUrl($this->image),
            'type' => $this->type,
            'progress_time' => $this->type == 'audio' ? $this->bookTrack->progress_time : '',
            'file_size' => $this?->pdf_file_size ?: '',
            'headlines' => PodcastHeadlineResource::collection($this->headlines),
        ];
    }
}
