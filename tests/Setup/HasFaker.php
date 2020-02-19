<?php


namespace Tests\Setup;

use \Faker\Generator as Faker;
use \Faker\Factory as Factory;

trait HasFaker
{
    protected Faker $faker;

    /**
     * A faker instance
     *
     * @return Faker
     */
    protected function faker() : Faker
    {
        return $this->faker ?? $this->faker = Factory::create('fr_FR');
    }
}