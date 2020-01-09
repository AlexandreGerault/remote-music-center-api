<?php

namespace Tests\Unit;
use App\Player;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Facades\Tests\Setup\PlayerFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlayerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_code_by_default()
    {
        $player = factory(Player::class)->create();

        $this->assertTrue($player->id !== null);
    }

    /** @test */
    public function it_can_have_a_password()
    {
        $player = PlayerFactory::withPassword('1234')->create();
        
        $this->assertTrue(Hash::check('1234', $player->password));
    }

    /** @test */
    public function it_can_have_users()
    {
        $player = PlayerFactory::withUsers(5)->create();
        
        $this->assertEquals(5, $player->users->count());
    }

    /** @test */
    public function it_can_have_songs()
    {
        $player = PlayerFactory::withSongs(2)->create();

        $this->assertEquals(2, $player->songs->count());
    }
}
