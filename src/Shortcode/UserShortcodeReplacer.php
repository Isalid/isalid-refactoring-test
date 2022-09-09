<?php

namespace Isalid\Shortcode;

use Isalid\Context\ApplicationContext;
use Isalid\Entity\User;

class UserShortcodeReplacer implements ShortcodeReplacer
{
    public function replace($text, array $data = [])
    {
        $APPLICATION_CONTEXT = ApplicationContext::getInstance();

        $_user = (isset($data['user']) and ($data['user'] instanceof User)) ? $data['user'] : $APPLICATION_CONTEXT->getCurrentUser();
        if ($_user) {
            (strpos($text, '[user:first_name]') !== false) and $text = str_replace('[user:first_name]', ucfirst(mb_strtolower($_user->firstname)), $text);
        }

        return $text;
    }
}