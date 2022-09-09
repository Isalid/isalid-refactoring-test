<?php
/**
 * Created by PhpStorm.
 * User: jl
 * Date: 09/09/22
 * Time: 22:52
 */

namespace Isalid\Tests\Shortcode;


use Isalid\Context\ApplicationContext;
use Isalid\Shortcode\UserShortcodeReplacer;

class UserShortcodeReplacerTest extends \PHPUnit_Framework_TestCase
{
    /** @var UserShortcodeReplacer */
    private $userShortcodeReplacer;

    private $faker;

    public function setUp()
    {
        $this->userShortcodeReplacer = new UserShortcodeReplacer();
        $this->faker = \Faker\Factory::create();
    }

    /**
     * @test
     */
    public function test()
    {
        $expectedUser = ApplicationContext::getInstance()->getCurrentUser();

        $text = "Hello [user:first_name]!";
        $expectedText = "Hello " . $expectedUser->firstname . "!";
        $result = $this->userShortcodeReplacer->replace($text);

        $this->assertEquals($expectedText, $result);
    }
}