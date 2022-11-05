<?php

declare(strict_types=1);

class UserProcessor extends AbstractTemplateProcessor
{
    public function process(string $text, $entity): string
    {
        if (!$entity instanceof User) {
            return $text;
        }
        $text = $this->replace($text, 'first_name', ucfirst(mb_strtolower($entity->firstname)));

        return $text;
    }

    protected function getPrefix(): string
    {
        return 'user';
    }
}
