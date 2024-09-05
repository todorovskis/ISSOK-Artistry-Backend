<?php

namespace App\Models\DTOs;

class ClientDto
{
    public string $username;
    public string $name;
    public ?int $age;
    public string $country;
    public string $profilePictureLocation;

    public function __construct(
        string $username,
        string $name,
        ?int $age,
        string $country,
        string $profilePictureLocation
    ) {
        $this->username = $username;
        $this->name = $name;
        $this->age = $age;
        $this->country = $country;
        $this->profilePictureLocation = $profilePictureLocation;
    }
}
