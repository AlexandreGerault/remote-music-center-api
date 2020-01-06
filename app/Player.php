<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Player extends Model
{
    /**
     * Return the attached users
     * 
     * @return HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }


    /**
     * Return the queued songs
     *
     * @return HasMany
     */
    public function songs():HasMany
    {
        return $this->hasMany(Song::class);
    }

    /**
     * Get a player by its code
     *
     * @param Builder $query
     * @param string $code
     *
     * @return Builder
     */
    public function scopeByCode(Builder $query, string $code)
    {
        return $query->where('code', $code);
    }
}
