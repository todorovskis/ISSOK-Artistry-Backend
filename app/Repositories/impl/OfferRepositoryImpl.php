<?php

namespace App\Repositories\impl;

use App\Models\Offer;
use App\Repositories\OfferRepository;
use Illuminate\Support\Collection;

class OfferRepositoryImpl implements OfferRepository
{

    public function findById(int $id): ?Offer
    {
        return Offer::find($id);
    }

    public function findByPriceBetween(float $minPrice, float $maxPrice): Collection
    {
        return Offer::whereBetween('price', [$minPrice, $maxPrice])->get();
    }

    public function findAll(): Collection
    {
        return Offer::orderBy('timeCreated', 'desc')->get();
    }

    public function findAllOffersByClient(string $username): Collection
    {
        return Offer::whereHas('client', function ($query) use ($username) {
            $query->whereHas('user', function ($query) use ($username) {
                $query->where('username', $username);
            });
        })->orderBy('timeCreated', 'desc')->get();
    }

    public function findAllByTitle(string $q): Collection
    {
        return Offer::where('title', 'like', "%{$q}%")->orderBy('timeCreated', 'desc')->get();
    }

    public function findAllOffersByArtistSignedUp(string $artistUsername): Collection
    {
        return Offer::whereHas('artistsSignedUp', function ($query) use ($artistUsername) {
            $query->whereHas('user', function ($query) use ($artistUsername) {
                $query->where('username', $artistUsername);
            });
        })->orderBy('timeCreated', 'desc')->get();
    }

    public function delete(int $offerId)
    {
        $offer = Offer::find($offerId);
        if ($offer) {
            return $offer->delete();
        }
        return false;
    }

    public function findAllOffersByArtistWorking(int $artistId): Collection
    {
        return Offer::where('artist_id', $artistId)->get();
    }
}
