<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookTrack extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'headline_id',
        'last_page_read',
        'progress_time',
    ];
}
