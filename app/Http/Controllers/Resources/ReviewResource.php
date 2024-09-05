<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'artistId' => $this->artistId,
            'clientId' => $this->clientId,
            'timeCreated' => $this->timeCreated,
            'title' => $this->title,
            'clientProfilePicture' => $this->clientProfilePicture,
            'grade' => $this->grade,
            'review' => $this->review,
        ];
    }
}
