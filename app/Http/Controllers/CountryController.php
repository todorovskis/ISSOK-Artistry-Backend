<?php

namespace App\Http\Controllers;

use App\Services\CountryService;
use App\Http\Resources\CountryResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CountryController extends Controller
{
    protected $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    public function getAllCountries() : JsonResponse
    {
        $countries = $this->countryService->getAllCountries();
        return response()->json($countries);
    }
}
