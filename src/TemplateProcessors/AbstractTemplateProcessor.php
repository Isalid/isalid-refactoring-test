<?php

declare(strict_types=1);

abstract class AbstractTemplateProcessor
{
    abstract public function process(string $text, $entity): string;

    abstract protected function getPrefix(): string;

    protected function replace(string $text, string $placeholderKey, $value): string
    {
        return str_replace($this->buildPlaceholder($placeholderKey), $value, $text);
    }

    protected function replaces(string $text, array $replaces): string
    {
        foreach ($replaces as $placeholderKey => $value) {
            $text = $this->replace($text, $placeholderKey, $value);
        }

        return $text;
    }

    private function buildPlaceholder(string $placeholderKey): string
    {
        return sprintf('[%s:%s]', $this->getPrefix(), $placeholderKey);
    }
}
