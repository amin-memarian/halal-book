<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $table = 'likes';

    protected $fillable = ['user_id', 'likeable_type', 'likeable_id'];

    public static function isLikedByUser(int $userId, string $table, int $rowId): bool
    {
        return self::query()->where([
            'user_id' => $userId,
            'likeable_type' => $table,
            'likeable_id' => $rowId,
        ])->exists();
    }

    public static function countLikes(string $table, int $rowId): int
    {
        return self::query()->where([
            'likeable_type' => $table,
            'likeable_id' => $rowId,
        ])->count();
    }

}
