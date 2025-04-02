<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItems extends Model
{
    use HasFactory;

    protected $table = 'cart_items';

    protected $fillable = [
        'user_id',
        'book_id',
        'quantity'
    ];

    protected $attributes = [
        'quantity' => 1
    ];

}
