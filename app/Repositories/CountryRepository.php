<?php

namespace App\Repositories;

use App\Models\Country;
use Illuminate\Support\Collection;

interface CountryRepository
{
    public function findById(int $id): ?Country;

    public function findAllCountriesOnlyWithName(): Collection;

    public function findByCountry(string $country): ?Country;
}
