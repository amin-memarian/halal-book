<?php

namespace App\Http\Resources\Api;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'user_id'       => $this->user_id,
            'name'          => $this->name,
            'avatar_image'  => Helper::generateFileUrl($this->avatar_image),
            'last_name'     => $this->last_name,
            'gender'        => $this->gender,
            'date_of_birth' => Helper::gregorianToShamsi($this->date_of_brith),
            'about'         => $this->about,
            'created_at'    => Helper::gregorianToShamsi($this->created_at),
        ];
    }
}
