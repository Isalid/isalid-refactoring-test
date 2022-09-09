<?php
require_once __DIR__ . '/../vendor/autoload.php';

$faker = \Faker\Factory::create();

$template = new Isalid\Entity\Template(
    1,
    'Votre livraison à [quote:destination_name]',
    "
Bonjour [user:first_name],

Merci de nous avoir contacté pour votre livraison à [quote:destination_name].

Bien cordialement,

L'équipe de Shipper
");
$templateManager = new Isalid\TemplateManager();

$message = $templateManager->getTemplateComputed(
    $template,
    [
        'quote' => new Isalid\Entity\Quote($faker->randomNumber(), $faker->randomNumber(), $faker->randomNumber(), $faker->date())
    ]
);

echo $message->subject . "\n" . $message->content;
