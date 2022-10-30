<?php

namespace App\Entity;

class Quote
{
    private int $id;
    private int $siteId;
    private int $destinationId;
    private \DateTimeInterface $dateQuoted;

    public function __construct(int $id, int $siteId, int $destinationId, \DateTimeInterface $dateQuoted)
    {
        $this->id = $id;
        $this->siteId = $siteId;
        $this->destinationId = $destinationId;
        $this->dateQuoted = $dateQuoted;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getSiteId(): int
    {
        return $this->siteId;
    }

    public function setSiteId(int $siteId): self
    {
        $this->siteId = $siteId;

        return $this;
    }

    public function getDestinationId(): int
    {
        return $this->destinationId;
    }

    public function setDestinationId(int $destinationId): self
    {
        $this->destinationId = $destinationId;

        return $this;
    }

    public function getDateQuoted(): \DateTimeInterface
    {
        return $this->dateQuoted;
    }

    public function setDateQuoted(\DateTimeInterface $dateQuoted): self
    {
        $this->dateQuoted = $dateQuoted;

        return $this;
    }


    public static function renderHtml(Quote $quote): string
    {
        return '<p>'.$quote->getId().'</p>';
    }

    public static function renderText(Quote $quote): string
    {
        return (string)$quote->getId();
    }
}