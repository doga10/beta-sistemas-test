<?php

namespace App\Entities;

use OpenApi\Annotations as OA;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Contact",
 *     @OA\Property(type="integer", property="id"),
 *     @OA\Property(type="integer", property="user_id"),
 *     @OA\Property(type="string", property="name"),
 *     @OA\Property(type="string", property="email"),
 *     @OA\Property(type="string", property="phone"),
 *     @OA\Property(type="string", property="created_at", format="date-time"),
 *     @OA\Property(type="string", property="updated_at", format="date-time"),
 * )
 */
class Contact extends Model
{
    protected $fillable = [
        'user_id', 'name', 'email', 'phone',
    ];

    public function user()
    {
        return $this->belongsTo('App\Entities\User');
    }
}
