<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    protected $fillable = ['country'];

    public function artists(): HasMany
    {
        return $this->hasMany(Artist::class);
    }

}
