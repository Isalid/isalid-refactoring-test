<?php

namespace Isalid\Shortcode;

use Isalid\Entity\Quote;
use Isalid\Repository\DestinationRepository;
use Isalid\Repository\SiteRepository;

class QuoteShortcodeReplacer implements ShortcodeReplacer
{
    const SHORTCODE_DESTINATION_NAME = '[quote:destination_name]';
    const SHORTCODE_DESTINATION_LINK = '[quote:destination_link]';
    const SHORTCODE_SUMMARY = '[quote:summary]';
    const SHORTCODE_SUMMARY_HTML = '[quote:summary_html]';

    public function replace($text, array $data = [])
    {
        $quote = (isset($data['quote']) and $data['quote'] instanceof Quote) ? $data['quote'] : null;

        if (!isset($quote)) {
            return $text;
        }

        $destination = DestinationRepository::getInstance()->getById($quote->destinationId);

        if (strpos($text, self::SHORTCODE_DESTINATION_NAME) !== false) {
            $text = str_replace(self::SHORTCODE_DESTINATION_NAME, $destination->countryName, $text);
        }

        if (strpos($text, self::SHORTCODE_DESTINATION_LINK) !== false) {
            $site = SiteRepository::getInstance()->getById($quote->siteId);
            $text = str_replace(self::SHORTCODE_DESTINATION_LINK, $site->url . '/' . $destination->countryName . '/quote/' . $quote->id, $text);
        }

        if (strpos($text, self::SHORTCODE_SUMMARY) !== false) {
            $text = str_replace(self::SHORTCODE_SUMMARY, Quote::renderText($quote), $text);
        }

        if (strpos($text, self::SHORTCODE_SUMMARY_HTML) !== false) {
            $text = str_replace(self::SHORTCODE_SUMMARY_HTML, Quote::renderHtml($quote), $text);
        }

        return $text;
    }
}