<?php

namespace App\Http\DTOs;

class ArtistFilterDto
{
    public array $categories;
    public int $minPrice;
    public int $maxPrice;

    public function __construct(array $categories,
                                int   $minPrice,
                                int   $maxPrice)
    {
        $this->categories = $categories;
        $this->minPrice = $minPrice;
        $this->maxPrice = $maxPrice;
    }
}
