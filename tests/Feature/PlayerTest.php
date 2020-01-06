<?php

namespace Tests\Feature;

use App\Song;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

    /** @test */
    public function a_user_can_join_a_player()
    {
        $this->withoutExceptionHandling();

        $player = PlayerFactory::create();
        $user = factory(User::class)->create();

        $this->actingAs($user);
        $this->assertEquals(null, $user->player);

        $this->get('join/' . $player->code)->assertStatus(200);

        $this->assertEquals($player->id, $user->player->id);
    }

    /** @test */
    public function a_user_can_leave_its_player()
    {
        $this->withoutExceptionHandling();

        $player = PlayerFactory::create();
        $user = factory(User::class)->create(['player_id' => $player->id]);

        $this->actingAs($user);

        $this->get('leave')->assertStatus(200);

        $this->assertNull($user->player);
    }

    /**
     * A client (User or Player) can ask for the next song
     *
     * @test
     */
    public function a_client_can_ask_next_song()
    {
        $player = PlayerFactory::withSongs(2)->create();

        $response = $this->get('next/' . $player->code)
            ->assertStatus(200)
            ->json();
    }
}
