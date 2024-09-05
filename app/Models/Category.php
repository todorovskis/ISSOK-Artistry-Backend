<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    protected $fillable = ['category'];

    public function artists(): BelongsToMany
    {
        return $this->belongsToMany(Artist::class, 'artist_categories', 'categoryId', 'artistId');
    }

}
