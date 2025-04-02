<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookExcerpt extends Model
{
    use HasFactory;

    protected $table = 'book_excerpts';

    protected $fillable = [
        'user_id',
        'book_id',
        'text',
        'likes_count',
        'comments_count'
    ];

    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class, 'product_id');
    }

}
