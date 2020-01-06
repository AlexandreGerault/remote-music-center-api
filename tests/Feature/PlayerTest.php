<?php

namespace Tests\Feature;

use App\Player;
use App\Song;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\PlayerFactory;
use Facades\Tests\Setup\SongFactory;
use Tests\TestCase;

class PlayerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_must_be_logged_to_add_a_song()
    {
        $songAttributes = factory(Song::class)->raw();

        $this->post('song/store', $songAttributes)->assertStatus(403);
    }

    /** @test */
    public function a_user_must_belongs_to_a_player_to_add_a_song()
    {
        $user = factory(User::class)->create(['player_id' => null]);

        $this->actingAs($user);

        $songAttributes = factory(Song::class)->raw();
        $this->post('song/store', $songAttributes)->assertStatus(403);
    }

    /** @test */
    public function a_user_can_add_a_song()
    {
        $player = PlayerFactory::create();
        $user = factory(User::class)->create(['player_id' => $player->id]);

        $this->actingAs($user);

        $songAttributes = SongFactory::addedBy($user)->toPlayer($player)->raw();

        $this->post('song/store', $songAttributes)->assertStatus(200);

        $this->assertDatabaseHas('songs', $songAttributes);
        $this->assertEquals(1, $player->songs->count());
    }
}
