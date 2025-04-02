<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = [
        'user_id',
        'transaction_id',
        'tracking_code',
        'gateway_name',
        'book_ids',
        'discount_amount',
        'paid_amount',
        'friend_mobile',
        'type',
        'status'
    ];

    protected $casts = [
        'book_ids' => 'array',
    ];

    public function books(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'payment_book', 'payment_id', 'book_id')
            ->withTimestamps();
    }

}
