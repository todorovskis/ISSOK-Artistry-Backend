<?php

namespace App\Repositories;

use App\Models\Client;

interface ClientRepository
{
    public function findById(int $id): ?Client;

    public function findByUsername(string $username): ?Client;
}
