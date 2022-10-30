<?php

use App\Entity\Template;
use App\Entity\Quote;
use App\TemplateManager;

require __DIR__.'/../vendor/autoload.php';

$faker = \Faker\Factory::create();

$template = new Template(
    1,
    'Votre livraison à [quote:destination_name]',
    "
Bonjour [user:first_name],

Merci de nous avoir contacté pour votre livraison à [quote:destination_name].

Bien cordialement,

L'équipe de Shipper
");
$userReplacer = new \App\Replacer\UserReplacer();
$destinationReplacer = new \App\Replacer\DestinationReplacer();
$summaryReplacer = new \App\Replacer\SummaryReplacer();
$summaryHTMLReplacer = new \App\Replacer\SummaryHTMLReplacer();
$templateManager = new TemplateManager($userReplacer, $destinationReplacer, $summaryReplacer, $summaryHTMLReplacer);

$message = $templateManager->getTemplateComputed(
    $template,
    ['quote' => new Quote($faker->randomNumber(), $faker->randomNumber(), $faker->randomNumber(), new \DateTime($faker->date()))]
);

echo $message->getSubject().PHP_EOL.$message->getContent();
