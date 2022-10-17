<?php
namespace Example;

require_once __DIR__ . '/../vendor/autoload.php';

use App\Context\ApplicationContext;
use App\Entity\Destination;
use App\Entity\Quote;
use App\Entity\Site;
use App\Entity\Template;
use App\Helper\TemplateHelper;
use App\Repository\DestinationRepository;
use App\Repository\QuoteRepository;
use App\Repository\SiteRepository;
use App\TemplateManager;
use DateTime;
use Faker\Factory;

$faker = Factory::create();

$quoteRepository = new QuoteRepository();
$siteRepository = new SiteRepository();
$destinationRepository = new DestinationRepository();

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
    $quoteRepository, 
    $siteRepository, 
    $destinationRepository,
    new TemplateHelper()
);

$site = $siteRepository->getById($faker->randomNumber());
$destination = $destinationRepository->getById($faker->randomNumber());

$message = $templateManager->getTemplateComputed(
    $template,
    [
        'quote' => new Quote($faker->randomNumber(), $site, $destination, new DateTime())
    ]
);

echo $message->getSubject() . "\n" . $message->getContent();
