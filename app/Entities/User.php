<?php

namespace App\Entities;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="User",
 *     @OA\Property(type="integer", property="id"),
 *     @OA\Property(type="string", property="name"),
 *     @OA\Property(type="string", property="email"),
 *     @OA\Property(type="string", property="password"),
 *     @OA\Property(type="string", property="created_at", format="date-time"),
 *     @OA\Property(type="string", property="updated_at", format="date-time"),
 * )
 */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token', 'email_verified_at'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function contacts()
    {
        return $this->hasMany('App\Entities\Contact');
    }
}
