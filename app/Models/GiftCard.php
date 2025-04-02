<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftCard extends Model
{
    use HasFactory;

    protected $table = 'gift_cards';

    protected $fillable = [
        'tracking_code',
        'amount',
        'type',
    ];


//    public function user(): \Illuminate\Database\Eloquent\Relations\HasOneThrough
//    {
//        return $this->hasOneThrough(
//            User::class,
//            'gift_card_user',
//            'gift_card_id',
//            'id',
//            'id',
//            'user_id'
//        );
//    }

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'gift_card_user', 'gift_card_id', 'user_id')
            ->withTimestamps();
    }

}
