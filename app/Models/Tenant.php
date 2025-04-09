<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $guarded = [
        'id'
    ];

    public function owner()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}