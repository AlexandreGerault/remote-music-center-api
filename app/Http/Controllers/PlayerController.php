<?php

namespace App\Http\Controllers;

use App\Player;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlayerController extends Controller
{
    /**
     * Change user's player
     *
     * @param String $code
     */
    public function join(String $code)
    {
        auth()->user()->joinPlayer($code);
    }

    /**
     * Make user leaves his player
     */
    public function leave()
    {
        auth()->user()->leavePlayer();
    }

    /**
     * Return the next song in json format
     *
     * @param string $code
     * @return ResponseFactory|Response
     */
    public function next(string $code)
    {
        $song = Player::byCode($code)->first()->songs->sortByDesc('created_at')->last();

        return response($song->toJson(), 200);
    }

    /**
     * Store a new player in database
     *
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function store(Request $request)
    {
        $player = Player::create([
            'password' => $request->get('password') ?? null
        ]);

        if ($player) return response($player->toJson(), 201);
    }
}
