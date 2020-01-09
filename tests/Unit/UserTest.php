<?php

namespace Tests\Unit;

use App\Song;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Player;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_does_not_belong_to_a_player_by_default()
    {
        $user = factory(User::class)->create();

        $this->assertEquals(null, $user->player);
    }

    /** @test */
    public function it_can_belongs_to_a_player()
    {
        $player = factory(Player::class)->create();
        $user = factory(User::class)->create(['player_id' => $player->id]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'player_id' => $player->id
        ]);
    }

    /** @test */
    public function it_has_songs()
    {
        $user = factory(User::class)->create();
        $song = factory(Song::class)->create([
            'added_by_id' => $user->id
        ]);

        $this->assertEquals($user->id, $song->addedBy->id);
    }
}
