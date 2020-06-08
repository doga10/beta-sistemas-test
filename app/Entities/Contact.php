<?php

namespace App\Entities;

use OpenApi\Annotations as OA;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema()
 */
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
