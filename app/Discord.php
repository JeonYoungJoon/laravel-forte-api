<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discord extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'discord_id', 'expiration_time', 'purchase_limit',
    ];
}