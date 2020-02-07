<?php

namespace App\Http\Middleware;

use App\Player;
use Closure;

class HasPlayer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->player instanceof Player)
            return $next($request);

        return response()->json([
            'message' => "You have to be logged and be related to a player!"
        ], 403);
    }
}
