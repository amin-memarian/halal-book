<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements  MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'avatar',
        'email',
        'phone',
        'password',
        'email_verified_at',
        'invite_code',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getAvatar(): string
    {
        return $this->avatar
            ? '/storage'.$this->avatar
            : asset('admin/assets/images/user/user.png');
    }

    public function hasVerifiedPhone(): bool
    {
        return ! is_null($this->phone_verified_at);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function bookTracks(): HasMany
    {
        return $this->hasMany(BookTrack::class);
    }

    public function invites(): HasMany
    {
        return $this->hasMany(Invite::class, 'user_id');
    }

    public function invitedBy(): HasOne
    {
        return $this->hasOne(Invite::class, 'invited_id');
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    public function cartItems()
    {
        return $this->belongsToMany(
            Product::class,
            'cart_items',
            'user_id',
            'book_id'
        )
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function profile(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Profile::class, 'id');
    }

    public function purchasedBooks()
    {

    }


}
