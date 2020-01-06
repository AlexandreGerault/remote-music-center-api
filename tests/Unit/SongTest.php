<?php

namespace Tests\Unit;

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
}
