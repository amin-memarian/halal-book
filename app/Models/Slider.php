<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'title',
        'image',
        'status',
        'order_number',
        'locale',
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    public function getImage(): string
    {
        return '/storage'.$this->image;
    }
}
