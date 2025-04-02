<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $with = ['user'];

    protected $fillable = [
        'user_id',
        'product_id',
        'comment',
        'rate',
        'status',
        'recommendation',
    ];

    protected $casts = [
        'status' => 'boolean',
        'recommendation' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function profile(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Profile::class, 'user_id');
    }

}
