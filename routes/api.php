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
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('register', 'UserAuthController@register');
    Route::post('login', 'UserAuthController@login')->name('login');
    Route::post('logout', 'UserAuthController@logout');
    Route::post('refresh', 'UserAuthController@refresh');
    Route::post('me', 'UserAuthController@me');

});

Route::post('songs/store', 'SongController@store')->middleware('player');
Route::get('next/{player}', 'PlayerController@next');

Route::post('players/join', 'PlayerController@join');
Route::post('players/leave', 'PlayerController@leave');
Route::post('players/store', 'PlayerController@store');