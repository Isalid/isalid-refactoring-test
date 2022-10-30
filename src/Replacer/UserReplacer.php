<?php


namespace App\Replacer;


use App\Context\ApplicationContext;
use App\Entity\User;

class UserReplacer implements Replacer
{
    private const USER_FIRST_NAME = '[user:first_name]';

    public function replace(string $subject, $object): string
    {
        $containFirstname = false !== strpos($subject, self::USER_FIRST_NAME);
        if (!$containFirstname) {
            return $subject;
        }

        $user = $this->getCurrentUser($object);

        return str_replace(self::USER_FIRST_NAME, $user->getFirstname(), $subject);
    }

    private function getCurrentUser(?User $user = null): User
    {
        $context = ApplicationContext::getInstance();

        return $user instanceof User ? $user : $context->getCurrentUser();
    }
}