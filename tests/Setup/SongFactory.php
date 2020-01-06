<?php
namespace Tests\Setup;

use App\Player;
use App\Song;
use App\User;

class SongFactory
{
    /**
     * The user that added the song
     *
     * @var User
     */
    protected User $user;

    /**
     * The player the song belongs to
     *
     * @var Player
     */
    protected Player $player;


    /**
     * Set the user that added the song
     *
     * @param User $user
     * @return SongFactory $this
     */
    public function addedBy(User $user) : SongFactory
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Set the player the song should belong to
     *
     * @param Player $player
     * @return SongFactory $this
     */
    public function toPlayer(Player $player) : SongFactory
    {
        $this->player = $player;
        return $this;
    }


    /**
     * Generate a parameterized song
     *
     * @return Song
     */
    public function create()
    {
        return factory(Song::class)->create([
            'player_id' => $this->player->id,
            'added_by_id' => $this->user->id
        ]);
    }

    /**
     * Generate a parameterized song as array
     *
     * @return array
     */
    public function raw()
    {
        return factory(Song::class)->raw([
            'player_id' => $this->player->id,
            'added_by_id' => $this->user->id
        ]);
    }
}