<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Player;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_belongs_to_a_player()
    {
        $user = factory(User::class)->create();
        $player = factory(Player::class)->create();

        $user->player()->associate($player);
        $user->save();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'player_id' => $player->id
        ]);
    }
}
