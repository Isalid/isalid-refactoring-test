<?php

namespace App\Entity;

class Site
{
    private int $id;
    private string $url;

    public function __construct(int $id, ?string $url)
    {
        if (isset($url) && !filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \RuntimeException('Param $url must be a valid URL.');
        }

        $this->id = $id;
        $this->url = $url;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
