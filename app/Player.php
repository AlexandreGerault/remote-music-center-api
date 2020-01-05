<?php

namespace App;

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
    public function songs() : HasMany
    {
        return $this->hasMany(Song::class);
    }
}
