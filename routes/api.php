<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('songs/store', 'SongController@store');
Route::post('players.join', 'PlayerController@join');
Route::post('players.leave', 'PlayerController@leave');
Route::get('next/{player}', 'PlayerController@next');
Route::post('players/store', 'PlayerController@store');