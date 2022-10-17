<?php
namespace Test;

use App\Context\ApplicationContext;
use App\Entity\Quote;
use App\Entity\Template;
use App\Entity\User;
use App\Helper\TemplateHelper;
use App\Repository\DestinationRepository;
use App\Repository\QuoteRepository;
use App\Repository\SiteRepository;
use App\TemplateManager;
use DateTime;
use Faker\Factory;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_TestCase;

require_once __DIR__ . '/../vendor/autoload.php';

class TemplateManagerTest extends TestCase
{
    /**
     * Init the mocks
     */
    protected function setUp(): void
    {
    }

    /**
     * Closes the mocks
     */
    protected function tearDown(): void
    {
    }

    /**
     * @testdox Test le template manager sans user.
     */
    public function testTemplateManagerWOUser()
    {
        $faker = Factory::create();

        $applicationContext = new ApplicationContext();

        $destinationId = $faker->randomNumber();
        $expectedDestination = (new DestinationRepository)->getById($destinationId);
        $expectedUser = $applicationContext->getCurrentUser();
        $site = (new SiteRepository)->getById($faker->randomNumber());

        $quote = new Quote($faker->randomNumber(), $site, $expectedDestination, new DateTime());

        $template = new Template(
            1,
            'Votre livraison à [quote:destination_name]',
            "
Bonjour [user:first_name],

Merci de nous avoir contacté pour votre livraison à [quote:destination_name].

Bien cordialement,

L'équipe de Shipper
");
        $templateManager = new TemplateManager(
            $applicationContext,
            new QuoteRepository(), 
            new SiteRepository(), 
            new DestinationRepository(),
            new TemplateHelper()
        );

        $message = $templateManager->getTemplateComputed(
            $template,
            [
                'quote' => $quote
            ]
        );

        $this->assertEquals('Votre livraison à ' . $expectedDestination->getCountryName(), $message->getSubject());
        $this->assertEquals("
Bonjour " . $expectedUser->getFirstname() . ",

Merci de nous avoir contacté pour votre livraison à " . $expectedDestination->getCountryName() . ".

Bien cordialement,

L'équipe de Shipper
", $message->getContent());
    }

    /**
     * @testdox Test le template manager avec un user.
     */
    public function testTemplateManagerWITHUser()
    {
        $faker = Factory::create();

        $destinationId = $faker->randomNumber();
        $expectedDestination = (new DestinationRepository)->getById($destinationId);
        $expectedUser = new User($faker->randomNumber(), 'Nicolas', 'VINCENT', 'nicolas.s.vincent@yopmail.com');
        $site = (new SiteRepository)->getById($faker->randomNumber());

        $quote = new Quote($faker->randomNumber(), $site, $expectedDestination, new DateTime());

        $template = new Template(
            1,
            'Votre livraison à [quote:destination_name]',
            "
Bonjour [user:first_name],

Merci de nous avoir contacté pour votre livraison à [quote:destination_name].

Bien cordialement,

L'équipe de Shipper
");
        $templateManager = new TemplateManager(
            new ApplicationContext(),
            new QuoteRepository(), 
            new SiteRepository(), 
            new DestinationRepository(),
            new TemplateHelper()
        );

        $message = $templateManager->getTemplateComputed(
            $template,
            [
                'quote' => $quote,
                'user' => $expectedUser
            ]
        );

        $this->assertEquals('Votre livraison à ' . $expectedDestination->getCountryName(), $message->getSubject());
        $this->assertEquals("
Bonjour " . $expectedUser->getFirstname() . ",

Merci de nous avoir contacté pour votre livraison à " . $expectedDestination->getCountryName() . ".

Bien cordialement,

L'équipe de Shipper
", $message->getContent());
    }
}
