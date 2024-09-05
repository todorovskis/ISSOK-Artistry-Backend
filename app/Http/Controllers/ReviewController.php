<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Requests\SubmitReviewRequest;
use App\Services\ReviewService;
use Illuminate\Http\JsonResponse;

class ReviewController extends Controller
{
    protected $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    public function getReviewsByArtist($artistId): JsonResponse
    {
        $reviews = $this->reviewService->getReviewsByArtist($artistId);
        return response()->json($reviews);
    }

    public function submitReview(SubmitReviewRequest $request): JsonResponse
    {
        $this->reviewService->submitReview($request);
        return response()->json(['message' => 'Review submitted successfully']);
    }
}
