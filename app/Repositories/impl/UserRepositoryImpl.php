<?php

namespace App\Repositories\impl;

use App\Models\Artist;
use App\Models\Client;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Collection;

class UserRepositoryImpl implements UserRepository
{
    public function findByUsername(string $username): ?User
    {
        return User::where('username', $username)->first();
    }

    public function findUserClientById(int $id): ?array
    {
        $artist = Client::where('id', $id)->first();

        if ($artist) {
            // Get the User associated with this Artist
            $user = User::where('id', $artist->userId)->first();

            return [
                'user' => $user,
                'artist' => $artist,
            ];
        }
        return null;
    }

    public function findUserArtistById(int $id): ?array
    {
        $artist = Artist::where('id', $id)->first();

        if ($artist) {
            // Get the User associated with this Artist
            $user = User::where('id', $artist->userId)->first();

            return [
                'user' => $user,
                'artist' => $artist,
            ];
        }
        return null;
    }

    public function findArtistByUsername(string $username): ?Artist
    {
        return Artist::whereHas('user', function ($query) use ($username) {
            $query->where('username', $username);
        })->first();
    }
}
