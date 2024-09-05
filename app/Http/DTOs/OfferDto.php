<?php

namespace App\Http\DTOs;

class OfferDto
{
    public $id;
    public $title;
    public $description;
    public $timeCreated;
    public $price;
    public $categories;
    public $status;
    public $artistsSignedUp;
    public $clientUsername;
    public array $contentLocations;
    public $clientProfilePicture;
    public $offerGeneratedImage;
    public $mode;

    public function __construct(
        $id,
        $title,
        $description,
        $timeCreated,
        $price,
        $categories,
        $status,
        $artistsSignedUp,
        $clientUsername,
        array $contentLocations,
        $clientProfilePicture, $offerGeneratedImage, $mode
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->timeCreated = $timeCreated;
        $this->price = $price;
        $this->categories = $categories;
        $this->status = $status;
        $this->artistsSignedUp = $artistsSignedUp;
        $this->clientUsername = $clientUsername;
        $this->contentLocations = $contentLocations;
        $this->clientProfilePicture = $clientProfilePicture;
        $this->offerGeneratedImage = $offerGeneratedImage;
        $this->mode = $mode;
    }
}
