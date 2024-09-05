<?php

namespace App\Http\DTOs;

class ArtistDto
{
    public $id;
    public $name;
    public $username;
    public $jobTitle;
    public $age;
    public $country;
    public $hourlyRate;
    public $summary;
    public $averageRating;
    public $totalReviews;
    public $profilePictureLocation;
    public $portfolioLocation;
    public $categories;

    public function __construct(
        $id,
        $name,
        $username,
        $jobTitle,
        $age,
        $country,
        $hourlyRate,
        $summary,
        $averageRating,
        $totalReviews,
        $profilePictureLocation,
        $portfolioLocation,
        $categories
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->username = $username;
        $this->jobTitle = $jobTitle;
        $this->age = $age;
        $this->country = $country;
        $this->hourlyRate = $hourlyRate;
        $this->summary = $summary;
        $this->averageRating = $averageRating;
        $this->totalReviews = $totalReviews;
        $this->profilePictureLocation = $profilePictureLocation;
        $this->portfolioLocation = $portfolioLocation;
        $this->categories = $categories;
    }
}
