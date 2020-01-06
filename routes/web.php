<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('song/store', 'SongController@store');
Route::get('join/{code}', 'PlayerController@join');
Route::get('leave', 'PlayerController@leave');
Route::get('next/{code}', 'PlayerController@next');