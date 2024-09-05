<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class Artist extends User
{
    protected $fillable = [
        'summary', 'hourlyRate', 'jobTitle', 'portfolio', 'userId'
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'artist_categories', 'artistId', 'categoryId');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function offersSignedUpTo(): BelongsToMany
    {
        return $this->belongsToMany(Offer::class, 'offers_artists_signed_up', 'artist_id', 'offer_id');
    }

    public function offersWorksOn(): HasMany
    {
        return $this->hasMany(Offer::class, 'artistWorking');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userId');
    }
}
