<?php

namespace App\Http\Controllers;

use App\Player;
use App\Song;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SongController extends Controller
{

    /**
     * Store a song
     *
     * @return ResponseFactory|Response
     */
    public function store()
    {
        if (auth()->guest() || auth()->check() && ! auth()->user()->player instanceof Player) {
            abort(403);
        }

        Song::create([
            'player_id' => auth()->user()->player->id,
            'added_by_id' => auth()->user()->id
        ]);

        return response(null, 201);
    }
}
