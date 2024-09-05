<?php

namespace App\Repositories;

use App\Models\Artist;
use Illuminate\Support\Collection;

interface ArtistRepository
{
    public function findByUserId(int $userId): ?Artist;

    public function findAll(): Collection;

    public function findById(int $id): ?Artist;

    public function findAllByName(string $query): Collection;

    public function findByHourlyRateBetween(float $minPrice, float $maxPrice): Collection;

    public function findAllByCategoriesAndPriceRange(
        array $categoryNames,
        float $minPrice,
        float $maxPrice): Collection;
}
