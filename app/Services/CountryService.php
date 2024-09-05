<?php

namespace App\Services;

use App\Models\Country;
use App\Repositories\CountryRepository;
use App\Http\Resources\CountryResource;
use Illuminate\Support\Collection;

class CountryService
{
    protected $countryRepository;

    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    public function getAllCountries(): Collection
    {
        $countries = $this->countryRepository->findAllCountriesOnlyWithName();
        return $countries->map(function ($country) {
            return new CountryResource($country);
        });
    }

    public function getCountryIdByName($name): Country
    {
        $country = $this->countryRepository->findByCountry($name);
        return $country;
    }
}
