<?php

namespace App\Http\Controllers;

use App\Player;
use App\Song;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SongController extends Controller
{

    /**
     * Store a song
     *
     * @return JsonResponse
     */
    public function store()
    {
        $song = Song::create([
            'player_id' => auth()->user()->player->id,
            'added_by_id' => auth()->user()->id
        ]);

        return response()->json($song->toJson(), 201);
    }
}
