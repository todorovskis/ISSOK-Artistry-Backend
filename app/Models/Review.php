<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'grade', 'title', 'review', 'timeCreated', 'artistId', 'clientId'
    ];

    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class, 'artistId');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'clientId');
    }
}
