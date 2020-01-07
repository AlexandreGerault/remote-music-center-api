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


Route::post('song/store', 'SongController@store');
Route::get('join/{code}', 'PlayerController@join');
Route::get('leave', 'PlayerController@leave');
Route::get('next/{code}', 'PlayerController@next');
Route::post('player/store', 'PlayerController@store');