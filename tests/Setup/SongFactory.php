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
     * Create a song with a fluent class
     *
     * @return Song
     */
    public function create()
    {
        return $this->apply('create');
    }

    /**
     * Create a song attributes array
     *
     * @return array
     */
    public function raw()
    {
        return $this->apply('raw');
    }


    /**
     * Local function to avoid code duplication
     *
     * @param string $method Possible methods are the factory methods ('create', 'make', 'raw')
     * @return mixed
     */
    private function apply(string $method = 'create')
    {
        return factory(Song::class)->$method([
            'player_id' => $this->player->id ?? factory(Player::class),
            'added_by_id' => $this->user->id ?? factory(User::class)
        ]);
    }
}