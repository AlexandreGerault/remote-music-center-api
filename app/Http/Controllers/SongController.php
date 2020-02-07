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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        if (auth()->guest() || auth()->check() && ! auth()->user()->player instanceof Player) {
            return response()->json([
                'message' => "You have to be logged and be related to a player!"
            ], 403);
        }

        $song = Song::create([
            'player_id' => auth()->user()->player->id,
            'added_by_id' => auth()->user()->id
        ]);

        return response()->json($song->toJson(), 201);
    }
}
