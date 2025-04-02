<?php

namespace App\Http\Resources\Api;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookExcerptResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return array(
          'id' => $this->id,
          'text' => $this->text,
          'likes_count' => Like::countLikes('books', $this->id),
          'comments_count' => $this->comments_count,
        );
    }
}
