<?php
namespace App\Context;

use App\Entity\Site;
use App\Entity\User;
use App\Helper\SingletonTrait;

class ApplicationContext
{
    use SingletonTrait;

    private Site $currentSite;
    private User $currentUser;

    public function __construct()
    {
        $faker = \Faker\Factory::create();
        $this->currentSite = new Site($faker->randomNumber(), $faker->url);
        $this->currentUser = new User($faker->randomNumber(), $faker->firstName, $faker->lastName, $faker->email);
    }

    public function getCurrentSite(): Site
    {
        return $this->currentSite;
    }

    public function getCurrentUser(): User
    {
        return $this->currentUser;
    }
}
