<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\Mode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'timeCreated',
        'timeWorkedOn',
        'content',
        'price',
        'mode',
        'artist_id',
        'client_id',
        'generatedImage'
    ];

    protected $casts = [
        'status' => 'string',
        'timeCreated' => 'datetime',
        'timeWorkedOn' => 'float',
        'price' => 'float',
        'mode' => Mode::class,
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'offer_categories', 'offer_id', 'category_id');
    }

    public function artistWorking(): BelongsTo
    {
        return $this->belongsTo(Artist::class, 'artist_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function artistsSignedUp(): BelongsToMany
    {
        return $this->belongsToMany(Artist::class, 'offers_artists_signed_up', 'offer_id', 'artist_id');
    }


}
