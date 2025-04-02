<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => $this->user->name,
            'user_avatar' => $this->user->getAvatar(),
            'comment' => $this->comment,
            'rate' => $this->rate,
            'recommendation' => $this->recommendation,
            'created_at' => $this->created_at,
        ];
    }
}
