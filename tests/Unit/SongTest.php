<?php

namespace Tests\Unit;

use App\Player;
use App\Song;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SongTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_is_added_by_user()
    {
        $song = factory(Song::class)->create();

        $this->assertTrue($song->addedBy !== null);
    }

    /** @test */
    public function it_belongs_to_a_player()
    {
        $player = factory(Player::class)->create();
        $song = factory(Song::class)->create([
            'player_id' => $player->id
        ]);

        $this->assertEquals($player->id, $song->player->id);
    }
}
