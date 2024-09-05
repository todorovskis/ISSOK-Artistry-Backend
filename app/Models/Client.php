<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends User
{
    protected $fillable = ['userId'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userId');
    }
}

