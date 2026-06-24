<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $fillable = ['email', 'locale', 'verified_at'];

    protected $casts = [
        'verified_at' => 'datetime',
    ];
}
