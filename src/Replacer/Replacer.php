<?php

namespace App\Replacer;

interface Replacer
{
    /** @var $object mixed Quote|User */
    public function replace(string $subject, $object): string;
}
