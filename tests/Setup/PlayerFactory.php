<?php
namespace Tests\Setup;
use App\Player;
use App\Song;
use App\User;

class PlayerFactory
{
    /**
     * The number of users connected to the player
     * 
     * @var int
     */
    protected int $usersCount = 0;

    /**
     * The number of songs in the player queue
     *
     * @var int
     */
    protected int $songsCount = 0;


    /**
     * The number of users attached to this player
     * 
     * @param int $count
     * @return PlayerFactory $this
     */
    public function withUsers($count) : PlayerFactory
    {
        $this->usersCount = $count;
        return $this;
    }

    /**
     * The number of songs to be attached to the player
     *
     * @param $count
     * @return PlayerFactory $this
     */
    public function withSongs($count) : PlayerFactory
    {
        $this->songsCount = $count;
        return $this;
    }


    /**
     * Generate a parameterized player
     * 
     * @return Player
     */
    public function create()
    {
        $player = factory(Player::class)->create();

        factory(User::class, $this->usersCount)->create(['player_id' => $player->id]);
        factory(Song::class, $this->songsCount)->create(['player_id' => $player->id]);

        return $player;
    }
}