<?php

namespace Tests\Feature;

use App\Player;
use App\Song;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\PlayerFactory;
use Facades\Tests\Setup\SongFactory;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PlayerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_must_be_logged_to_add_a_song()
    {
        $songAttributes = factory(Song::class)->raw();

        $this->post('api/songs/store', $songAttributes)->assertStatus(403);
    }

    /** @test */
    public function a_user_must_belongs_to_a_player_to_add_a_song()
    {
        $user = factory(User::class)->create(['player_id' => null]);

        $this->actingAs($user);

        $songAttributes = factory(Song::class)->raw();
        $this->post('api/songs/store', $songAttributes)->assertStatus(403);
    }

    /** @test */
    public function a_user_can_add_a_song()
    {
        $this->withoutExceptionHandling();
        $player = PlayerFactory::create();
        $user = factory(User::class)->create(['player_id' => $player->id]);

        $this->actingAs($user);

        $songAttributes = SongFactory::addedBy($user)->toPlayer($player)->raw();

        $this->post('api/songs/store', $songAttributes)->assertStatus(201);

        $this->assertDatabaseHas('songs', $songAttributes);
        $this->assertEquals(1, $player->songs->count());
    }

    /** @test */
    public function a_user_can_join_an_unprotected_player()
    {
        $this->withoutExceptionHandling();

        $player = PlayerFactory::create();
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $this->post('api/players/join', ['player' => $player->id])->assertStatus(200);

        $this->assertEquals($player->id, $user->player->id);
    }

    /** @test */
    public function a_user_cannot_join_a_protected_player_without_its_password()
    {
        $player = PlayerFactory::withPassword("protected")->create();
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $this->post('api/players/join', ['player' => $player->id])->assertStatus(403);
    }

    /** @test */
    public function a_user_can_join_a_protected_player_with_its_password()
    {
        $player = PlayerFactory::withPassword("protected")->create();
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $this->post('api/players/join', [
            'player' => $player->id,
            'password' => 'protected'
        ])->assertStatus(200);
    }

    /** @test */
    public function a_user_can_leave_its_player()
    {
        $player = PlayerFactory::create();
        $user = factory(User::class)->create(['player_id' => $player->id]);

        $this->actingAs($user);

        $this->post('api/players/leave')->assertStatus(200);

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

        $response = $this->get('api/next/' . $player->id)
            ->assertStatus(200)
            ->json();
    }

    /** @test */
    public function a_user_can_create_a_player_without_password()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $player = factory(Player::class)->raw();

        $this->actingAs($user);

        $response_data = json_decode($this->post('api/players/store', $player)->assertStatus(201)->decodeResponseJson());

        $this->assertEquals(null,  $response_data->password);
    }

    /** @test */
    public function a_user_can_create_a_player_with_password()
    {
        $user = factory(User::class)->create();
        $player = factory(Player::class)->raw(['password' => 'my_pass']);

        $this->actingAs($user);

        $response_data = json_decode($this->post('api/players/store', $player)->assertStatus(201)->decodeResponseJson());

        $this->assertTrue(Hash::check('my_pass', $response_data->password));
    }

    /** @test */
    public function a_user_cannot_join_nonexistent_player()
    {
        $user = factory(User::class)->create();

        $this->post('api/players/join', ['player' => 'aaa'])->assertStatus(404);
    }

    /** @test */
    public function a_user_must_be_able_to_ask_player_information()
    {
        $player = PlayerFactory::create();
        $user = factory(User::class)->create(['player_id' => $player->id]);

        $this->actingAs($user);

        $this->get('api/players/current')
            ->assertStatus(200);
    }
}
