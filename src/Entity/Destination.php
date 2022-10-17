<?php

namespace App\Entity;

class Destination
{
    private int $id;
    private string $countryName;
    private string $conjunction;
    private string $name;
    private string $computerName;

    public function __construct(int $id, ?string $countryName, ?string $conjunction, ?string $computerName)
    {
        $this->id = $id;
        $this->countryName = $countryName;
        $this->conjunction = $conjunction;
        $this->computerName = $computerName;
    }

    public function getCountryName(): string
    {
        return $this->countryName;
    }
}
