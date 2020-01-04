<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

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
}
