<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{

    public function addedBy()
    {
        return $this->belongsTo(User::class);
    }
}
