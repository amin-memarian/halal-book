<?php

namespace App\Http\Resources\Api\BookExcerpt;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookExcerptCommentResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'text' => $this->comment,
            'avatar' => $this->profile->avatar_image ? Helper::generateImageUrl($this->profile->avatar_image) : ''
        ];
    }
}
