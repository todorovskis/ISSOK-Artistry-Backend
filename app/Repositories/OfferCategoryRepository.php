<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

interface OfferCategoryRepository
{
    public function findOfferCategoriesByOffer(int $id): Collection;
}
