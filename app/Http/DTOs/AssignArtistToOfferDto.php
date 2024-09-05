<?php

namespace App\Http\DTOs;

class AssignArtistToOfferDto
{
    public int $artistId;
    public int $offerId;

    public function __construct(int $artistId, int $offerId)
    {
        $this->artistId = $artistId;
        $this->offerId = $offerId;
    }
}
