<?php

namespace App\Repositories\impl;

use App\Models\Client;
use App\Repositories\ClientRepository;

class ClientRepositoryImpl implements ClientRepository
{
    public function findByUsername(string $username): ?Client
    {
        return Client::whereHas('user', function ($query) use ($username) {
            $query->where('username', $username);
        })->first();
    }

    public function findById(int $id): ?Client
    {
        return Client::find($id);
    }
}
