<?php

namespace Tests\Unit;
use App\Player;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlayerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_code_by_default()
    {
        $player = factory(Player::class)->create();
        dump($player);

        $this->assertTrue($player->code !== null);
    }
}
