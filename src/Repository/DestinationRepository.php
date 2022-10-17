<?php

namespace App\Repository;

use App\Entity\Destination;
use App\Helper\SingletonTrait;
use Faker\Factory;

class DestinationRepository implements Repository
{
    public function getById(int $id): Destination
    {
        // DO NOT MODIFY THIS METHOD
        $generator    = Factory::create();
        $generator->seed($id);
        return new Destination($id, $generator->country, 'en', $generator->slug());
    }
}
