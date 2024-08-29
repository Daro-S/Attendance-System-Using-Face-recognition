<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $casts = [
        'abilities' => 'json',
        'last_used_at' => 'datetime',
        'expires_at' => 'datetime',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'token',
    ];

    public static function findAccessToken(string $token): PersonalAccessToken|bool
    {
        $accessToken = self::findToken($token);
        if (empty($accessToken)) {
            return false;
        }
        return $accessToken;
    }

}
