<?php

namespace App\Repositories\impl;

use App\Http\Resources\CountryResource;
use App\Models\Client;
use App\Models\Country;
use App\Repositories\CountryRepository;
use Illuminate\Support\Collection;

class CountryRepositoryImpl implements CountryRepository
{
    public function findAllCountriesOnlyWithName(): Collection
    {
        return Country::all();
    }

    public function findByCountry(string $country): ?Country
    {
        return Country::where('country', $country)->first();
    }

    public function findById(int $id): ?Country
    {
        return Country::find($id);
    }
}
