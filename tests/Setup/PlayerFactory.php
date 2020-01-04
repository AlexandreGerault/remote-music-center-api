<?php
namespace Tests\Setup;
use App\Player;
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
     * The number of users attached to this player
     * 
     * @param int $count
     * @return ProjectFactory $this
     */
    public function withUsers($count)
    {
        $this->usersCount = $count;
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
        $users  = factory(User::class, $this->usersCount)->create();

        $player->users()->saveMany($users);
        $player->save();

        return $player;
    }
}