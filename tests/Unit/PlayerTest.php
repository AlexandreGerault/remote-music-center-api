<?php

namespace Tests\Unit;
use App\Player;
use Tests\TestCase;
use Facades\Tests\Setup\PlayerFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\QueryException;

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
    /*public function its_code_must_be_unique()
    {
        $uuid = uniqid();

        $this->expectException(QueryException::class);

        $player1 = factory(Player::class)->create(['code' => $uuid]);
        $player2 = factory(Player::class)->create(['code' => $uuid]);
    }*/
    
    /** @test */
    public function it_can_have_a_password()
    {
        $player = PlayerFactory::withPassword('1234')->create();
        
        $this->assertEquals('1234', $player->password);
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
