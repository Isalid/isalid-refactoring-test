<?php

namespace App\Replacer;

use App\Entity\Quote;

class SummaryHTMLReplacer implements Replacer
{
    private const SUMMARY_HTML = '[quote:summary_html]';

    public function replace(string $subject, $object): string
    {
        $containsSummaryHtml = false !== strpos($subject, self::SUMMARY_HTML);
        if (!$containsSummaryHtml) {
            return $subject;
        }

        return str_replace(
            self::SUMMARY_HTML,
            Quote::renderHtml($object),
            $subject
        );
    }
}