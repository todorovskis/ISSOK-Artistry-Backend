<?php

namespace App\Repositories;

use Illuminate\Support\Collection;
use App\Models\Offer;

interface OfferRepository
{
    public function delete(int $offerId);

    public function findById(int $id): ?Offer;

    public function findByPriceBetween(float $minPrice, float $maxPrice): Collection;

    public function findAll(): Collection;

    public function findAllOffersByClient(string $username): Collection;

    public function findAllByTitle(string $q): Collection;

    public function findAllOffersByArtistSignedUp(string $artistUsername): Collection;

    public function findAllOffersByArtistWorking(int $artistId): Collection;
}
