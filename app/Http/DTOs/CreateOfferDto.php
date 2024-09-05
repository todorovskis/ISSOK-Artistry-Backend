<?php

namespace App\Http\DTOs;

class CreateOfferDto
{
    public string $title;
    public string $description;
    public string $status;
    public int $timeCreated;
    public float $price;
    public array $categories;
    public ?string $image;

    public function __construct(
        string  $title,
        string  $description,
        string  $status,
        int     $timeCreated,
        float   $price,
        array   $categories,
        ?string $image = null
    )
    {
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
        $this->timeCreated = $timeCreated;
        $this->price = $price;
        $this->categories = $categories;
        $this->image = $image;
    }
}
