<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookCase extends Model
{
    use HasFactory;

    protected $table = 'book_cases';

    protected $fillable = [
        'user_id',
        'name'
    ];

    public function books(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'book_case_books', 'book_case_id', 'book_id')
            ->withTimestamps();
    }



}
