<?php

namespace App\Http\Controllers;

use App\Http\DTOs\ArtistFilterDto;
use App\Services\ArtistService;
use App\Http\Dto\ArtistDto;
use App\Http\Dto\FilePathDto;
use Illuminate\Http\Request;

class ArtistsController extends Controller
{
    protected $artistService;

    public function __construct(ArtistService $artistService)
    {
        $this->artistService = $artistService;
    }

    // Get all artists or search by name/category
    public function getAllArtists(Request $request)
    {
        $q = $request->query('q');
        return response()->json(
            !empty($q) ? $this->artistService->findAllByNameOrCategory($q) : $this->artistService->findAll()
        );
    }

    // Filter artists by categories and price range
    public function filterArtistsByCategoriesAndPriceRange(Request $request)
    {
        $data = $request->json()->all();
        $artistFilterDto = new ArtistFilterDto(
            $data['categories'],
            $data['minPrice'],
            $data['maxPrice']
        );
        return response()->json($this->artistService->findByCategoriesAndPriceRange($artistFilterDto));
    }

    // Filter artists by price range
    public function filterArtistsByPriceRange(Request $request)
    {
        $minPrice = $request->query('minPrice');
        $maxPrice = $request->query('maxPrice');
        return response()->json($this->artistService->findAllByPriceRange($minPrice, $maxPrice));
    }

    // Get artist by ID
    public function getArtistById($id)
    {
        return response()->json($this->artistService->findById($id));
    }

    // Get artist by username
//    public function getArtistByUsername($username)
//    {
//        return response()->json($this->artistService->findByUsername($username));
//    }

    // Get artist's portfolio by ID
    /**
     * @throws \Exception
     */
    public function getArtistPortfolioById($id)
    {
        return response()->json($this->artistService->findPortfolioById($id));
    }
}
