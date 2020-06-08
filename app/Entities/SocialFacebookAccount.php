<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="SocialFacebookAccount",
 *     @OA\Property(type="integer", property="id"),
 *     @OA\Property(type="integer", property="user_id"),
 *     @OA\Property(type="string", property="provider_user_id"),
 *     @OA\Property(type="string", property="provider"),
 *     @OA\Property(type="string", property="created_at", format="date-time"),
 *     @OA\Property(type="string", property="updated_at", format="date-time"),
 * )
 */
class SocialFacebookAccount extends Model
{
    protected $fillable = ['user_id', 'provider_user_id', 'provider'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
