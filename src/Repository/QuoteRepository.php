<?php

namespace App\Repository;

use App\Entity\Destination;
use App\Entity\Quote;
use App\Entity\Site;
use App\Helper\SingletonTrait;
use DateTime;
use Faker\Factory;

class QuoteRepository implements Repository
{
    public function getById(int $id): Quote
    {
        // DO NOT MODIFY THIS METHOD
        $generator = Factory::create();
        $generator->seed($id);
        return new Quote(
            $id,
            new Site($generator->numberBetween(1, 10), null),
            new Destination($generator->numberBetween(1, 200), null, null, null),
            new DateTime()
        );
    }
}
