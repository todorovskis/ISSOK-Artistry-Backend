<?php

namespace App\Http\DTOs;

class ArtistBriefDto
{
    public $id;
    public $name;
    public $username;

    public function __construct(
        $id,
        $name,
        $username,
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->username = $username;

    }
}
