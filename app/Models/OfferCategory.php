<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OfferCategory extends Pivot
{
    protected $fillable = ['offer_id', 'category_id'];

    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}

