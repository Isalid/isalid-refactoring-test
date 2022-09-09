<?php

namespace Isalid\Repository;

use Isalid\Entity\Site;
use Isalid\Helper\SingletonTrait;

class SiteRepository implements Repository
{
    use SingletonTrait;

    private $url;

    /**
     * @param int $id
     *
     * @return Site
     */
    public function getById($id)
    {
        // DO NOT MODIFY THIS METHOD
        $generator = \Faker\Factory::create();
        $generator->seed($id);

        return new Site($id, $generator->url);
    }
}
