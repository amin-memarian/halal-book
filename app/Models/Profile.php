<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profiles';

    protected $fillable = [
        'user_id',
        'name',
        'last_name',
        'password',
        'gender',
        'date_of_brith',
        'about',
        'avatar_image'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected $attributes = [
        'gender' => 'male'
    ];

}
