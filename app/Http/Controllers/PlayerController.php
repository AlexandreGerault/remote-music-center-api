<?php

namespace App\Http\Controllers;

use App\Player;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlayerController extends Controller
{
    /**
     * Change user's player
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function join(Request $request)
    {
        $player = Player::findOrFail($request->get('player'));

        auth()->user()->joinPlayer($player);

        return response()->json($player->toJson(), 200);
    }

    /**
     * Make user leaves his player
     */
    public function leave()
    {
        auth()->user()->leavePlayer();

        return response()->json([], 200);
    }

    /**
     * Return the next song in json format
     *
     * @param Player $player
     * @return ResponseFactory|Response
     */
    public function next(Player $player)
    {
        $song = $player->songs->sortByDesc('created_at')->last();

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
