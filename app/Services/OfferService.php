<?php

namespace App\Services;

use App\Enums\Mode;
use App\Enums\OfferStatus;
use App\Exceptions\InvalidOfferIdException;
use App\Exceptions\InvalidClientUsernameException;
use App\Exceptions\InvalidArtistUsernameException;
use App\Exceptions\NonAuthenticatedRequestException;
use App\Http\Controllers\Requests\AssignArtistToOfferRequest;
use App\Http\Controllers\Requests\ContentToOfferRequest;
use App\Http\Controllers\Requests\CreateOfferRequest;
use App\Http\DTOs\ArtistBriefDto;
use App\Http\DTOs\FilePathDto;
use App\Http\DTOs\OfferDto;
use App\Models\Offer;
use App\Models\Category;
use App\Models\Client;
use App\Models\Artist;
use App\Repositories\OfferRepository;
use App\Repositories\ClientRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ArtistRepository;
use App\Repositories\UserRepository;
use Faker\Core\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Ramsey\Collection\Collection;

class OfferService
{
    protected $offerRepository;
    protected $clientRepository;
    protected $categoriesRepository;
    protected $artistRepository;
    protected $userRepository;

    public function __construct(
        OfferRepository    $offerRepository,
        ClientRepository   $clientRepository,
        CategoryRepository $categoriesRepository,
        ArtistRepository   $artistRepository,
        UserRepository     $userRepository
    )
    {
        $this->offerRepository = $offerRepository;
        $this->clientRepository = $clientRepository;
        $this->categoriesRepository = $categoriesRepository;
        $this->artistRepository = $artistRepository;
        $this->userRepository = $userRepository;
    }

    public function findById(int $offerId)
    {
        $offer = $this->offerRepository->findById($offerId);
        return $this->mapOfferToDto($offer);
    }

    public function findAll()
    {
        $offers = $this->offerRepository->findAll()->map(function ($offer) {
            return $this->mapOfferToDto($offer);
        });
        return $offers;
    }

    public function findAllByTitleOrCategory($q)
    {
        $offers = $this->offerRepository->findAllByTitle($q)->map(function ($offer) {
            return $this->mapOfferToDto($offer);
        });;
        return $offers;
    }

    public function findAllByClient($username)
    {
        return $this->offerRepository->findAllOffersByClient($username)->map(function ($offer) {
            return $this->mapOfferToDto($offer);
        });
    }

    public function findAllByArtistSignedUp($artistUsername)
    {
        $offers = $this->offerRepository->findByArtistSignedUp($artistUsername);
        return $this->mapOffersToDto($offers);
    }

    private function mapOffersToDto($offers)
    {
        return array_map([$this, 'mapOfferToDto'], $offers);
    }

    private function mapOfferToDto($offer): OfferDto
    {
        $currentTimestamp = now();
        $timeCreated = $offer->timeCreated;
        $duration = $currentTimestamp->diff($timeCreated);

        $timeAgo = $this->getTimeAgo($duration);

        $result = $this->userRepository->findUserClientById($offer->client_id);
        $clientUser = $result['user'];
        $clientUsername = $clientUser->username;
        $contentLocations = $this->findFilePaths("offer_content/{$offer->id}/", $offer->id);

        $generatedImageUrl = "";
        if ($offer->generatedImage) {
            $generatedImageUrl = 'http://localhost:8080/' . $offer->generatedImage;
        }

        return new OfferDto(
            id: $offer->id,
            title: $offer->title,
            description: $offer->description,
            timeCreated: $timeAgo,
            price: $offer->price,
            categories: $offer->categories->pluck('category')->toArray(),
            status: $offer->status,
            artistsSignedUp: $offer->artistsSignedUp->map(function ($artist) {
                $result = $this->userRepository->findUserArtistById($artist->id);
                $artistUser = $result['user'];
                return new ArtistBriefDto(
                    id: $artistUser->id,
                    name: $artistUser->name,
                    username: $artistUser->username
                );
            })->toArray(),
            clientUsername: $clientUsername,
            contentLocations: $contentLocations,
            clientProfilePicture: 'http://localhost:8080/storage/user_images/' . $clientUser->profilePicture,
            offerGeneratedImage: $generatedImageUrl,
            mode: $offer->mode
        );
    }

    private function getTimeAgo($duration)
    {
        if ($duration->i < 1) {
            return "just now";
        }
        if ($duration->i == 1) {
            return "1 minute ago";
        }
        if ($duration->h < 1) {
            return "{$duration->i} minutes ago";
        }
        if ($duration->h == 1) {
            return "1 hour ago";
        }
        if ($duration->days < 1) {
            return "{$duration->h} hours ago";
        }
        if ($duration->days == 1) {
            return "1 day ago";
        }
        return "{$duration->days} days ago";
    }

    public function downloadAndStoreImage($imageUrl, $offerId)
    {
        try {
            $response = Http::withOptions(['verify' => false])->get($imageUrl);

            if ($response->successful()) {
                $imageContent = $response->body();
                if (empty($imageContent)) {
                    return null;
                }

                $fileExtension = pathinfo(parse_url($imageUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
                $folderName = "ai-generated-images";
                $filename = "{$offerId}-generated-image.{$fileExtension}";
                $filePath = "{$folderName}/{$filename}";
                $stored = Storage::disk('public')->put($filePath, $imageContent);

                if ($stored) {
                    return Storage::url($filePath);
                } else {
                    return null;
                }
            } else {
                return null;
            }
        } catch (\Exception $e) {
            Log::error('Error in downloadAndStoreImage: ' . $e->getMessage());
            return null;
        }
    }


    public function createOffer(CreateOfferRequest $request): OfferDto
    {
        $user = auth()->guard('api')->user();
        $client = $this->clientRepository->findByUsername($user->username);
        $categories = Category::whereIn('category', $request->input('categories'))->get();
        $mode = $request->input('mode') === 'true' ? 'TOURNAMENT' : 'REGULAR';

        $offer = new Offer([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'status' => $request->input('status'),
            'timeCreated' => now(),
            'price' => $request->input('price'),
            'client_id' => $client->id,
            'mode' => $mode,
        ]);

        $offer->save();

        if ($request->has('selectedImageUrl') && $request->input('selectedImageUrl')) {
            $imagePath = $this->downloadAndStoreImage($request->input('selectedImageUrl'), $offer->id);
            $offer->generatedImage = $imagePath;
            $offer->save();
        }

        $offer->categories()->attach($categories->pluck('id'));
        return $this->mapOfferToDto($offer);
    }


    public function updateOffer($request)
    {
        $offer = $this->offerRepository->findById($request->id);
        $categories = Category::whereIn('category', $request->categories)->get();
        $offer->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
        ]);
        $offer->categories()->sync($categories);
        $offer->save();
        return $this->mapOfferToDto($offer);
    }

    public function deleteOffer($offerId)
    {
        $this->offerRepository->delete($offerId);
    }

    public function unassignOffer(int $offerId): OfferDto
    {
        $offer = $this->offerRepository->findById($offerId);
        $offer->artist_id = null;
        $offer->status = OfferStatus::PENDING->name;
        $offer->save();
        return $this->mapOfferToDto($offer);
    }


    public function signUpArtistToOffer($offerId)
    {
        Log::debug('signUpArtistToOffer', ['offerId' => $offerId]);
        $offer = $this->offerRepository->findById($offerId);
        $artist = $this->artistRepository->findByUsername(auth()->guard('api')->user()->username);

        if (!$offer->artistsSignedUp->contains($artist)) {
            $offer->artistsSignedUp()->attach($artist);
            $offer->save();
        }

        return $this->mapOfferToDto($offer);
    }

    public function getSignedUpOffersFor($artistUsername)
    {
//        $artist = $this->userRepository->findArtistByUsername($artistUsername);
//        if ($artist) {
//            return $artist->offersSignedUpTo->map(function ($offer) {
//                return $this->mapOfferToDto($offer);
//            });
//        }
//        return collect();
        $artist = $this->userRepository->findArtistByUsername($artistUsername);
        if ($artist) {
            $offers = $artist->offersSignedUpTo;
            Log::info('Offers signed up to 11: ', $offers->toArray());
            return $offers->map(function ($offer) {
                return $this->mapOfferToDto($offer);
            });
        }
        return collect();

    }

    public function removeArtistFromOffer($offerId, $artistUsername)
    {
        Log::info('Offer ID: ' . $offerId);
        Log::info('Artist Username: ' . $artistUsername);
        $offer = $this->offerRepository->findById($offerId);
        $artist = $this->userRepository->findArtistByUsername($artistUsername);
        if ($offer->artistsSignedUp->contains($artist)) {
            $offer->artistsSignedUp()->detach($artist);
            $offer->save();
        }
        return true;
    }

    public function getWorkingOnOffersFor($artistUsername)
    {
        $artist = $this->userRepository->findArtistByUsername($artistUsername);
        return $this->offerRepository->findAllOffersByArtistWorking($artist->id)
            ->map(function($offer) {
                return $this->mapOfferToDto($offer);
            })
            ->toArray();    }

    public function findOfferContentById(int $offerId): FilePathDto
    {
        $this->offerRepository->findById($offerId);
        $directoryPath = 'offer_content/' . $offerId;
        $filePaths = $this->findFilePaths($directoryPath, $offerId);
        return new FilePathDto($filePaths);
    }

    private function findFilePaths($directoryPath, $offerId)
    {
        $files = collect(Storage::disk('public')->files($directoryPath));
        return $files->map(function ($filePath) use ($offerId) {
            $artistName = $this->getArtistNameFromFile(basename($filePath));
            return ['url' => "http://localhost:8080/storage/offer_content/{$offerId}/" . basename($filePath),
                'artistUsername' => $artistName];
        })->toArray();
    }

    public function addContentToOffer(ContentToOfferRequest $contentToOfferFormDto): ?array
    {
        $offer = $this->offerRepository->findById($contentToOfferFormDto['offerId']);
        $artist = $this->userRepository->findArtistByUsername($contentToOfferFormDto['artistUsername']);
        return $this->handleOfferContentUpload($contentToOfferFormDto['content'], $offer, $artist);
    }

    private function handleOfferContentUpload($file, $offer, $artist): ?array
    {
        if ($file) {
            $fileExtension = $file->extension();
            $filename = "{$offer->id}-{$artist->id}-" . now()->timestamp . "." . $fileExtension;
            $folderPath = "offer_content/{$offer->id}";
            $file->storeAs($folderPath, $filename, 'public');
            $fileUrl = "http://localhost:8080/storage/{$folderPath}/" . $filename;
            return [$fileUrl];
        }
        return null;
    }


    public function deleteContent($offerId)
    {
        $offer = $this->offerRepository->find($offerId);
        if (!$offer) {
            throw new InvalidOfferIdException();
        }

        $fileToDelete = $this->findOfferContentById($offerId)['path'];
        if ($fileToDelete) {
            Storage::delete($fileToDelete);
        }

        return true;
    }

    private function getArtistNameFromFile($fileName)
    {
        preg_match('/^(\d+)-(\d+)-/', $fileName, $matches);

        if (isset($matches[2])) {
            $artistId = (int)$matches[2];
            $artist = $this->userRepository->findUserArtistById($artistId);
            return $artist ? $artist['user']->username : null;
        }

        return null;
    }

    public function assignArtistOnOffer(AssignArtistToOfferRequest $request): OfferDto
    {
        $offer = $this->offerRepository->findById($request->offerId);
        $artist = $this->artistRepository->findbyUserId($request->artistId);
        $offer->artist_id = $artist->id;
//        $offer->artistsSignedUp()->detach();
        if ($offer->mode == Mode::TOURNAMENT) {
            $this->completeOffer($offer->id);
        } else $offer->status = OfferStatus::IN_PROGRESS->name;
        $offer->save();
        return $this->mapOfferToDto($offer);
    }

    public function completeOffer(int $offerId): OfferDto
    {
        $offer = $this->offerRepository->findById($offerId);
        $offer->status = OfferStatus::COMPLETED->name;
        $offer->save();
        return $this->mapOfferToDto($offer);
    }

    public function findAllByPriceRange(float $minPrice, float $maxPrice): array
    {
        $offers = $this->offerRepository->findByPriceBetween($minPrice, $maxPrice);
        return array_map([$this, 'mapOfferToDto'], $offers->toArray());
    }

}
