<?php

namespace App\Http\Resources\Api;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{

    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => Helper::generateImageUrl($this->image),
            'type' => $this->type,
            'progress_time' => $this->type == 'audio' ? $this->bookTrack->progress_time : '',
            'last_page_read' => $this->type == 'text' ? $this->bookTrack->last_page_read : '',
        ];
    }
}
