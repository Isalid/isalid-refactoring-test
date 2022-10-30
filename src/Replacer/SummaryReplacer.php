<?php


namespace App\Replacer;


use App\Entity\Quote;

class SummaryReplacer implements Replacer
{
    private const SUMMARY = '[quote:summary]';

    public function replace(string $subject, $object): string
    {
        $containsSummary = false !== strpos($subject, self::SUMMARY);
        if (!$containsSummary) {
            return $subject;
        }

        return str_replace(
            self::SUMMARY,
            Quote::renderText($object),
            $subject
        );
    }
}