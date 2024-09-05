<?php

namespace App\Services;

use App\Http\Controllers\Requests\SubmitReviewRequest;
use App\Http\DTOs\ReviewDto;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use App\Repositories\impl\OfferRepositoryImpl;
use App\Repositories\impl\ReviewRepositoryImpl;
use App\Repositories\impl\UserRepositoryImpl;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ReviewService
{
    private $reviewRepository;
    private $offerRepository;
    private $userRepository;

    public function __construct(
        ReviewRepositoryImpl $reviewRepository,
        OfferRepositoryImpl  $offerRepository,
        UserRepositoryImpl   $userRepository,
    )
    {
        $this->reviewRepository = $reviewRepository;
        $this->offerRepository = $offerRepository;
        $this->userRepository = $userRepository;
    }


    public function getReviewsByArtist($artistId)
    {
        $reviews = $this->reviewRepository->getAllByArtist($artistId);
        return $reviews->map(function ($review) {
            return new ReviewDto(
                $review->artistId,
                $review->clientId,
                $review->timeCreated,
                $review->title,
                Storage::disk('public')->url('user_images/' . $this->userRepository->findUserClientById($review->clientId)['user']->profilePicture),
                $review->grade,
                $review->review
            );
        });
    }

    public function submitReview(SubmitReviewRequest $request)
    {
        $offer = $this->offerRepository->findById($request->offerId);
        $timeCreated = Carbon::createFromTimestamp($request->timeCreated / 1000);
        $review = new Review([
            'grade' => $request->grade,
            'title' => $request->title,
            'review' => $request->review,
            'timeCreated' => $timeCreated,
            'artistId' => $offer->artist_id,
            'clientId' => $offer->client_id
        ]);
        $review->save();
    }

}
