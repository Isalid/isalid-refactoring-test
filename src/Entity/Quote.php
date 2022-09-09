<?php

namespace Isalid\Entity;

class Quote
{
    public $id;
    public $siteId;
    public $destinationId;
    public $dateQuoted;

    public function __construct($id, $siteId, $destinationId, $dateQuoted)
    {
        $this->id = $id;
        $this->siteId = $siteId;
        $this->destinationId = $destinationId;
        $this->dateQuoted = $dateQuoted;
    }

    public function renderHtml()
    {
        return '<p>' . $this->id . '</p>';
    }

    public function renderText()
    {
        return (string) $this->id;
    }
}