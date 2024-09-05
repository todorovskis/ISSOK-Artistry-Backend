<?php

namespace App\Http\DTOs;

class ReviewDto
{
    public $artistId;
    public $clientId;
    public $timeCreated;
    public $title;
    public $clientProfilePicture;
    public $grade;
    public $review;

    public function __construct(
        $artistId,
        $clientId,
        $timeCreated,
        $title,
        $clientProfilePicture,
        $grade,
        $review
    )
    {
        $this->artistId = $artistId;
        $this->clientId = $clientId;
        $this->timeCreated = $timeCreated;
        $this->title = $title;
        $this->clientProfilePicture = $clientProfilePicture;
        $this->grade = $grade;
        $this->review = $review;
    }
}
