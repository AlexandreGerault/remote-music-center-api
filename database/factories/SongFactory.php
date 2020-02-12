<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Player;
use App\Song;
use App\User;
use Faker\Generator as Faker;

$factory->define(Song::class, function (Faker $faker) {
    return [
        'player_id' => factory(Player::class),
        'added_by_id' => factory(User::class),
        'url' => 'https://www.youtube.com/watch?v=e27dqYb6B3w'
    ];
});
