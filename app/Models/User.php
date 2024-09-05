<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $fillable = [
        'username', 'password', 'name', 'age', 'profilePicture', 'role', 'countryId'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return ['role' => $this->role, 'username' => $this->username];
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function artist()
    {
        return $this->hasOne(Artist::class);
    }

    public function client()
    {
        return $this->hasOne(Client::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'countryId');
    }

    public function isArtist()
    {
        return $this->role === 'ARTIST';
    }

    public function isClient()
    {
        return $this->role === 'CLIENT';
    }
}
