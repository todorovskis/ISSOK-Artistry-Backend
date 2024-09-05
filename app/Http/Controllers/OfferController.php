<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Requests\AssignArtistToOfferRequest;
use App\Http\Controllers\Requests\ContentToOfferRequest;
use App\Http\Controllers\Requests\UpdateOfferRequest;
use App\Http\DTOs\OfferDto;
use App\Services\OfferService;
use App\Http\Controllers\Requests\CreateOfferRequest;
use App\Http\Requests\ContentToOfferFormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OfferController extends Controller
{
    protected $offerService;

    public function __construct(OfferService $offerService)
    {
        $this->offerService = $offerService;
    }

    public function getOfferById(int $offerId): JsonResponse
    {
        $offerDto = $this->offerService->findById($offerId);
        return response()->json($offerDto);
    }

    public function getAllOffers(Request $request): JsonResponse
    {
        $q = $request->query('q');
        if (!empty($q)) {
            return response()->json($this->offerService->findAllByTitleOrCategory($q));
        }
        return response()->json($this->offerService->findAll());
    }

    public function getAllOffersByClient($username)
    {
        return response()->json($this->offerService->findAllByClient($username));
    }

    public function getAllOffersByArtist($username): JsonResponse
    {
        return response()->json($this->offerService->findAllByArtistSignedUp($username));
    }

    public function createOffer(CreateOfferRequest $request)
    {
        $offerDto = $this->offerService->createOffer($request);
        return response()->json($offerDto);
    }

    public function updateOffer(UpdateOfferRequest $request)
    {
        $offerDto = $this->offerService->updateOffer($request);
        return response()->json($offerDto);
    }

    public function deleteOffer(Request $request)
    {
        $offerId = $request->input('offerId');
        $this->offerService->deleteOffer($offerId);
        return response()->noContent();
    }

    public function signUpArtistToOffer(Request $request)
    {
        $offerId = $request->input('offerId');
        $offerDto = $this->offerService->signUpArtistToOffer($offerId);
        return response()->json($offerDto);
    }

    public function viewSignedUpOffersFor($artistUsername)
    {
        $offers = $this->offerService->getSignedUpOffersFor($artistUsername);
        return response()->json($offers);
    }

    public function assignArtistOnOffer(AssignArtistToOfferRequest $request): JsonResponse
    {
        $offerDto = $this->offerService->assignArtistOnOffer($request);
        return response()->json($offerDto);
    }

    public function unassignOffer(Request $request)
    {
        $offerId = $request->input('offerId');
        $offerDto = $this->offerService->unassignOffer($offerId);
        return response()->json($offerDto);
    }

    public function viewWorkingOnOffersFor($artistUsername)
    {
        $offers = $this->offerService->getWorkingOnOffersFor($artistUsername);
        return response()->json($offers);
    }

    public function removeArtistFromOffer(Request $request)
    {
        $this->offerService->removeArtistFromOffer($request->input('offerId'),
            $request->input('artistUsername'));
        return response()->noContent();
    }

    public function addContentToOffer(ContentToOfferRequest $request)
    {
        $offerDto = $this->offerService->addContentToOffer($request);
        return response()->json($offerDto);
    }

    public function getContentForOffer($id)
    {
        $filePathDto = $this->offerService->findOfferContentById($id);
        return response()->json($filePathDto);
    }

    public function completeOffer(Request $request)
    {
        $offerId = $request->input('offerId');
        $offerDto = $this->offerService->completeOffer($offerId);
        return response()->json($offerDto);
    }

    public function filterOffersByPriceRange(Request $request)
    {
        $minPrice = (float) $request->query('minPrice');
        $maxPrice = (float) $request->query('maxPrice');
        $offers = $this->offerService->findAllByPriceRange($minPrice, $maxPrice);
        return response()->json($offers);
    }
}
