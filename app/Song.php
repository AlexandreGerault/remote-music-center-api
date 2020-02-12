<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Song extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'player_id',
        'added_by_id',
        'url'
    ];

    /**
     * Return the user that added the song
     *
     * @return BelongsTo
     */
    public function addedBy()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Return the player the song is related to
     *
     * @return BelongsTo
     */
    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
