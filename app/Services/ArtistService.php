<?php

namespace App\Services;

use App\Http\Dto\ArtistRegisterDto;
use App\Http\Dto\AuthenticationDto;
use App\Http\Dto\FilePathDto;
use App\Http\DTOs\ArtistBriefDto;
use App\Http\DTOs\ArtistDto;
use App\Http\DTOs\ArtistFilterDto;
use App\Http\Requests\ArtistFilterRequest;
use App\Http\Requests\ArtistRegisterRequest;
use App\Http\Resources\FilePathResource;
use App\Models\Artist;
use App\Repositories\ArtistRepository;
use App\Repositories\CountryRepository;
use App\Repositories\ReviewRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ArtistService
{
    protected $artistRepo;
    protected $reviewRepo;
    protected $countryRepo;
    protected $userRepository;

    public function __construct(
        ArtistRepository  $artistRepo,
        ReviewRepository  $reviewRepo,
        CountryRepository $countryRepo,
        UserRepository    $userRepository
    )
    {
        $this->artistRepo = $artistRepo;
        $this->reviewRepo = $reviewRepo;
        $this->countryRepo = $countryRepo;
        $this->userRepository = $userRepository;
    }

    public function findAll(): Collection
    {
        return $this->artistRepo->findAll()->map(function ($artist) {
            return $this->mapFromArtistToDto($artist);
        });
    }

    public function findAllByNameOrCategory(string $q): Collection
    {
        return $this->artistRepo->findAllByName($q)->map(function ($artist) {
            return $this->mapFromArtistToDto($artist);
        });
    }

    public function findById(int $id): ArtistDto
    {
        $artist = $this->artistRepo->findById($id);
        return $this->mapFromArtistToDto($artist);
    }

    public function findPortfolioById(int $id): FilePathResource
    {
        $artist = $this->artistRepo->findById($id);
        if (!$artist) {
            throw new \Exception("Artist not found");
        }
        $portfolioPath = $artist->portfolio;
        if ($portfolioPath === '/path/to/portfolio') {
            return new FilePathResource(null);
        }
        return new FilePathResource(Storage::url("portfolio/{$artist->username}-portfolio.pdf"));
    }

    public function findAllByPriceRange(float $minPrice, float $maxPrice): Collection
    {
        return $this->artistRepo->findByHourlyRateBetween($minPrice, $maxPrice)->map(function ($artist) {
            return $this->mapFromArtistToDto($artist);
        });
    }

    public function findByCategoriesAndPriceRange(ArtistFilterDto $request): Collection
    {
        $artists = $this->artistRepo->findAllByCategoriesAndPriceRange($request->categories, $request->minPrice, $request->maxPrice, count($request->categories));
        return $artists->map(function ($artist) {
            return $this->mapFromArtistToDto($artist);
        });
    }

    private function mapFromArtistToDto(Artist $artist): ArtistDto
    {
        $reviews = $this->reviewRepo->getAllByArtist($artist->id);
        $totalReviews = $reviews->count();
        $sumOfGrades = $reviews->sum('grade');
        $averageRating = $totalReviews > 0 ? $sumOfGrades / $totalReviews : 0.0;

        $userArtist = $this->userRepository->findUserArtistById($artist->id)['user'];
        $country = $this->countryRepo->findById($userArtist->countryId);

        Log::info('$userArtist: ' . $userArtist);

        return new ArtistDto(
            $artist->id,
            $artist->name,
            $userArtist->username ?? 'Unknown',
            $artist->jobTitle,
            $artist->age,
            $country->country,
            $artist->hourlyRate,
            $artist->summary,
            $averageRating,
            $totalReviews,
            Storage::disk('public')->url('user_images/' . $userArtist->profilePicture), // Use Laravel Storage URL helper
            "",
            $artist->categories->pluck('category')->toArray()
        );
    }


}
