<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = ['name', 'birthday', 'died_at', 'bio', 'avatar', 'nationality', 'type'];

    const TYPES = [
        'author',
        'translator',
        'speaker',
    ];

    public function getAvatar()
    {
        return $this->avatar
            ? '/storage' . $this->avatar
            : asset('admin/assets/images/avtar/avatar-1.jpg');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
