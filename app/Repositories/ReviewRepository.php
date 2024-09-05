<?php

namespace App\Repositories;

use App\Models\Review;
use Illuminate\Support\Collection;

interface ReviewRepository
{
    public function getAllByArtist(int $id): Collection;
}
