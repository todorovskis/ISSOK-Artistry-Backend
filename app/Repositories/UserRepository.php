<?php

namespace App\Repositories;

use App\Models\Artist;
use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepository
{
    public function findByUsername(string $username): ?User;

    public function findArtistByUsername(string $username): ?Artist;

    public function findUserClientById(int $id): ?array;

    public function findUserArtistById(int $id): ?array;

}
