<?php

namespace Isalid\Shortcode;

use Isalid\Context\ApplicationContext;
use Isalid\Entity\User;

class UserShortcodeReplacer implements ShortcodeReplacer
{
    const SHORTCODE_USER_FIRSTNAME = '[user:first_name]';

    public function replace($text, array $data = [])
    {
        $context = ApplicationContext::getInstance();

        $user = (isset($data['user']) and ($data['user'] instanceof User)) ? $data['user'] : $context->getCurrentUser();

        if (!isset($user)) {
            return $text;
        }

        $text = str_replace(self::SHORTCODE_USER_FIRSTNAME, ucfirst(strtolower($user->firstname)), $text);

        return $text;
    }
}