<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArtistResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'jobTitle' => $this->jobTitle,
            'age' => $this->age,
            'country' => $this->country,
            'hourlyRate' => $this->hourlyRate,
            'summary' => $this->summary,
            'averageRating' => $this->averageRating,
            'totalReviews' => $this->totalReviews,
            'profilePictureLocation' => $this->profilePictureLocation,
            'portfolioLocation' => $this->portfolioLocation,
            'categories' => $this->categories,
        ];
    }
}
