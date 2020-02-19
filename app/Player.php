<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Player extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
        'password'
    ];

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
}
