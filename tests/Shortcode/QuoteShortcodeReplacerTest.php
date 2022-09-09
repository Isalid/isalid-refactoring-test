<?php

namespace Isalid\Tests\Shortcode;

use Isalid\Entity\Quote;
use Isalid\Repository\DestinationRepository;
use Isalid\Shortcode\QuoteShortcodeReplacer;

class QuoteShortcodeReplacerTest extends \PHPUnit_Framework_TestCase
{
    /** @var QuoteShortcodeReplacer */
    private $quoteShortcodeReplacer;

    private $faker;

    public function setUp()
    {
        $this->quoteShortcodeReplacer = new QuoteShortcodeReplacer();
        $this->faker = \Faker\Factory::create();
    }

    /**
     * @test
     */
    public function test()
    {
        $destinationId = $this->faker->randomNumber();
        $expectedDestination = DestinationRepository::getInstance()->getById($destinationId);

        $quote = new Quote($this->faker->randomNumber(), $this->faker->randomNumber(), $destinationId, $this->faker->date());
        $text = "Texte random pour tester la destination : [quote:destination_name].";
        $expectedText = "Texte random pour tester la destination : " . $expectedDestination->countryName . ".";
        $result = $this->quoteShortcodeReplacer->replace($text, ['quote' => $quote]);

        $this->assertEquals($expectedText, $result);
    }

    //TODO ideas: test with empty data, inexisting destination, error in shortcodes, etc...
}