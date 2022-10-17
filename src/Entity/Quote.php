<?php

namespace App\Entity;

use DateTime;

class Quote
{
    private int $id;
    private Site $site;
    private Destination $destination;
    private DateTime $date;

    public function __construct(?int $id, Site $site, Destination $destination, DateTime $date)
    {
        $this->id = $id;
        $this->site = $site;
        $this->destination = $destination;
        $this->date = $date;
    }

    public static function renderHtml(Quote $quote)
    {
        return '<p>' . $quote->id . '</p>';
    }

    public static function renderText(Quote $quote)
    {
        return (string) $quote->id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getSite(): Site
    {
        return $this->site;
    }

    public function getDestination(): Destination
    {
        return $this->destination;
    }
}
