<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'code',
        'discount',
        'capacity',
        'used',
        'status',
        'min_order_amount',
        'users',
        'products',
        'valid_from',
        'valid_to',
    ];

    protected $casts   = [
        'products' => 'array',
        'status' => 'boolean',
        'users' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        /*static::deleting(function (Address $address) {
            foreach ($address->orders as $payment) {
                $payment->update(['address_id' => null]);
            }
        });*/
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
