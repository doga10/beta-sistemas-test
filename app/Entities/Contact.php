<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'user_id', 'name', 'email', 'phone',
    ];

    public function user()
    {
        return $this->belongsTo('App\Entities\User', 'user_id', 'id');
    }
}
