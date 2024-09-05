<?php

namespace App\Providers;

use App\Models\User;
use PHPOpenSourceSaver\JWTAuth\Providers\Auth\Illuminate;
use Illuminate\Contracts\Auth\UserProvider as UserProviderContract;

class CustomJwtProvider extends Illuminate
{
    public function retrieveById($identifier)
    {
        return User::find($identifier);
    }

    public function retrieveByToken($identifier, $token)
    {
        return User::where('id', $identifier)->first();
    }

    public function updateRememberToken(UserProviderContract $user, $token)
    {
        // No-op
    }
}
