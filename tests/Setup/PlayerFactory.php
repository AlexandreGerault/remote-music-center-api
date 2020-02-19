<?php
namespace Tests\Setup;
use App\Player;
use App\Song;
use App\User;
use Illuminate\Support\Facades\Hash;

class PlayerFactory
{
    use HasFaker;

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
     * An optional password
     *
     * @var string
     */
    protected string $password = "";

    /**
     * A required string
     *
     * @var string
     */
    protected string $name = "";


    /**
     * The number of users attached to this player
     * 
     * @param int $count
     * @return PlayerFactory $this
     */
    public function withUsers(int $count) : PlayerFactory
    {
        $this->usersCount = $count;
        return $this;
    }

    /**
     * The number of songs to be attached to the player
     *
     * @param int $count
     * @return PlayerFactory $this
     */
    public function withSongs(int $count) : PlayerFactory
    {
        $this->songsCount = $count;
        return $this;
    }

    /**
     * The password to protect the player
     *
     * @param string $password
     * @return PlayerFactory
     */
    public function withPassword(string $password) : PlayerFactory
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Set the player's name
     *
     * @param string $name
     * @return PlayerFactory
     */
    public function withName(string $name) : PlayerFactory
    {
        $this->name = $name;
        return $this;
    }


    /**
     * Generate a parameterized player
     * 
     * @return Player
     */
    public function create()
    {
        $player = factory(Player::class)->create([
            'name' => $this->name ? $this->name : $this->faker()->unique()->name,
            'password' => strlen($this->password) ? Hash::make($this->password) : null
        ]);

        factory(User::class, $this->usersCount)->create(['player_id' => $player->id]);
        factory(Song::class, $this->songsCount)->create(['player_id' => $player->id]);

        return $player;
    }
}