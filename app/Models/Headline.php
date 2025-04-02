<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Headline extends Model
{
    protected $fillable = [
        'product_id',
        'title',
        'time',
        'file',
        'status',
        'order_number'
    ];

    protected $casts = [
        'status' => 'boolean',
        'time' => 'array'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getFile()
    {
        return '/storage' . $this->file;
    }
}
