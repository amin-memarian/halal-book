<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_number',
        'user_id',
        'discount_id',
        'price',
        'total_price',
        'discount_price',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    public function getRouteKeyName(): string
    {
        return 'order_number';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->order_number = rand(11111111, 99999999);
        });

        /*static::forceDeleting(function (Order $order) {
            $order->payments()->delete();
        });*/
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function discount(): BelongsTo
    {
        return $this->belongsTo(Discount::class);
    }
}
