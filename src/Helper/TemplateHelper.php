<?php

namespace App\Helper;

class TemplateHelper
{
    public function checkForParam(string $name, string $text): bool
    {
        return strpos($text, $name);
    }
}
