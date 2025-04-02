<?php

namespace App\Services;

use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeService
{
    public function toggleLike(string $table, int $rowId)
    {
        $userId = Auth::id();

        if (Like::isLikedByUser($userId, $table, $rowId)) {
            return $this->removeLike($table, $rowId);
        }

        return $this->addLike($table, $rowId);
    }

    private function addLike(string $table, int $rowId)
    {
        return Like::query()->create([
            'user_id' => Auth::id(),
            'likeable_type' => $table,
            'likeable_id' => $rowId,
        ]);
    }

    private function removeLike(string $table, int $rowId)
    {
        return Like::query()->where([
            'user_id' => Auth::id(),
            'likeable_type' => $table,
            'likeable_id' => $rowId,
        ])->delete();
    }

}

