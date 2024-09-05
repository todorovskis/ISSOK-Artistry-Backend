<?php
namespace App\Repositories\impl;

use App\Models\OfferCategory;
use App\Repositories\OfferCategoryRepository;
use Illuminate\Support\Collection;

class OfferCategoryRepositoryImpl implements OfferCategoryRepository {

    public function findOfferCategoriesByOffer(int $id): Collection
    {
        return OfferCategory::where('offerId', $id)
            ->with('category')
            ->get()
            ->pluck('category');
    }
}
