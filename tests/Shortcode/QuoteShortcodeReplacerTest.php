<?php

namespace Isalid\Tests\Shortcode;

use Isalid\Entity\Quote;
use Isalid\Repository\DestinationRepository;
use Isalid\Repository\SiteRepository;
use Isalid\Shortcode\QuoteShortcodeReplacer;

class QuoteShortcodeReplacerTest extends \PHPUnit_Framework_TestCase
{
    /** @var QuoteShortcodeReplacer */
    private $quoteShortcodeReplacer;

    private $faker;

    public function setUp()
    {
        $this->quoteShortcodeReplacer = new QuoteShortcodeReplacer();
    }

    /**
     * @test
     * @dataProvider dataProvider
     */
    public function testQuoteShortcodes($quote, $template, $expectedText)
    {
        $result = $this->quoteShortcodeReplacer->replace($template, ['quote' => $quote]);
        $this->assertEquals($expectedText, $result);
    }

    public function dataProvider()
    {
        $faker = \Faker\Factory::create();

        $quoteId = $faker->randomNumber();
        $destinationId = $faker->randomNumber();
        $expectedDestination = DestinationRepository::getInstance()->getById($destinationId);
        $siteId = $faker->randomNumber();
        $expectedSite = SiteRepository::getInstance()->getById($siteId);

        $quote = new Quote($quoteId, $siteId, $destinationId, $faker->date());

        return [
            'quote:destination_name' => [
                $quote,
                'Texte random pour tester la destination : [quote:destination_name].',
                'Texte random pour tester la destination : ' . $expectedDestination->countryName . '.'
            ],
            'quote:destination_link' => [
                $quote,
                'Texte avec [quote:destination_link].',
                'Texte avec ' . $expectedSite->url . '/' . $expectedDestination->countryName . '/quote/' . $quoteId . '.',
            ],
            'quote:summary_html' => [
                $quote,
                '[quote:summary_html]',
                '<p>'.$quoteId.'</p>'
            ],
            'quote:summary' => [
                $quote,
                '[quote:summary]',
                $quoteId
            ]
        ];
    }

    //TODO ideas: test with empty data, inexisting destination, error in shortcodes, etc...
}