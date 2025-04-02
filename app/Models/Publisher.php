<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    protected $fillable = ['name', 'description', 'logo'];

    public function getLogo()
    {
        return '/storage' . $this->logo;
    }
}
