<?php

namespace App\Http\Controllers;

use App\Player;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

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
        try {
            $player = Player::find($request->get('player'));
        } catch (ModelNotFoundException $exception) {
            return response()->json(null, 404);
        }

        if(
            $player->password && Hash::check($request->get('password'), $player->password)
            || $player->password === null
        ) {
            auth()->user()->joinPlayer($player);
            return response()->json($player->toJson(), 200);
        }

        return response()->json(null, 403);
    }

    /**
     * Make user leaves his player
     */
    public function leave()
    {
        auth()->user()->leavePlayer();

        return response()->json(null, 200);
    }

    /**
     * Return the next song in json format
     *
     * @param Player $player
     * @return JsonResponse
     */
    public function next(Player $player)
    {
        $song = $player->songs->sortByDesc('created_at')->last();

        return response()->json($song->toJson(), 200);
    }

    /**
     * Store a new player in database
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $player = Player::create([
            'password' => ($password = $request->get('password')) === null ? null : Hash::make($password),
        ]);

        if ($player) return response()->json($player->toJson(), 201);
    }
}
