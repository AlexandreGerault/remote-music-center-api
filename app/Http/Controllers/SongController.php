<?php

namespace App\Http\Controllers;

use App\Player;
use App\Song;
use Illuminate\Http\Request;

class SongController extends Controller
{

    public function store()
    {
        if (auth()->guest() || auth()->check() && ! auth()->user()->player instanceof Player) {
            abort(403);
        }

        Song::create([
            'player_id' => auth()->user()->player->id,
            'added_by_id' => auth()->user()->id
        ]);
    }
}
