<?php

namespace App\Repositories\impl;

use App\Models\Review;
use App\Repositories\ReviewRepository;
use Illuminate\Support\Collection;

class ReviewRepositoryImpl implements ReviewRepository
{
    public function getAllByArtist(int $id): Collection
    {
        return Review::where('artistId', $id)
            ->orderBy('timeCreated', 'desc')
            ->get();
    }
}
