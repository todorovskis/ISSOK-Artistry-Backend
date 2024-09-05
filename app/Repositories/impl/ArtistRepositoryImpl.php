<?php

namespace App\Repositories\impl;

use App\Models\Artist;
use App\Repositories\ArtistRepository;
use Illuminate\Support\Collection;

class ArtistRepositoryImpl implements ArtistRepository
{
    /**
     * Find an artist by their username.
     */
    public function findByUsername(string $userName): ?Artist
    {
        return Artist::whereHas('user', function ($query) use ($userName) {
            $query->where('username', $userName);
        })->first();
    }

    /**
     * Find all artists.
     */
    public function findAll(): Collection
    {
        return Artist::with('user')->get();
    }

    /**
     * Find artists by a partial name match.
     */
    public function findAllByName(string $query): Collection
    {
        return Artist::whereHas('user', function ($queryBuilder) use ($query) {
            $queryBuilder->where('username', 'like', "%{$query}%");
        })->get();
    }

    /**
     * Find artists with hourly rates between a given range.
     */
    public function findByHourlyRateBetween(float $minPrice, float $maxPrice): Collection
    {
        return Artist::whereBetween('hourlyRate', [$minPrice, $maxPrice])->get();
    }

    /**
     * Find artists by categories and hourly rate range, ensuring they belong to a specified number of categories.
     */
    public function findAllByCategoriesAndPriceRange(
        array $categoryNames,
        float $minPrice,
        float $maxPrice): Collection {
        return Artist::select('artists.*', 'users.name') // Select artists and the related user fields
        ->join('users', 'artists.userId', '=', 'users.id') // Join with the users table
        ->join('artist_categories', 'artists.id', '=', 'artist_categories.artistId')
            ->join('categories', 'categories.id', '=', 'artist_categories.categoryId')
            ->whereIn('categories.category', $categoryNames)
            ->whereBetween('artists.hourlyRate', [$minPrice, $maxPrice])
            ->get();
    }

    /**
     * Find an artist by their ID.
     */
    public function findById(int $id): ?Artist
    {
        return Artist::with('user')->find($id); // Load the related user as well
    }

    public function findByUserId(int $userId): ?Artist
    {
        return Artist::where('userId', $userId)->first();
    }
}
