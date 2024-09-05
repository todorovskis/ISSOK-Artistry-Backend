<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'timeCreated' => $this->timeCreated,
            'price' => $this->price,
            'categories' => $this->categories,
            'status' => $this->status,
            'artistsSignedUp' => ArtistBriefResource::collection($this->artistsSignedUp),
            'clientUsername' => $this->clientUsername,
            'contentLocation' => $this->contentLocation,
            'clientProfilePicture' => $this->clientProfilePicture,
        ];
    }
}
