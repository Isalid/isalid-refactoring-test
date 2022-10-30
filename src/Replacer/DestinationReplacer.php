<?php


namespace App\Replacer;


use App\Context\ApplicationContext;
use App\Entity\Quote;
use App\Entity\User;
use App\Repository\DestinationRepository;
use App\Repository\SiteRepository;

class DestinationReplacer implements Replacer
{
    private const DESTINATION_NAME = '[quote:destination_name]';
    private const DESTINATION_LINK = '[quote:destination_link]';

    public function replace(string $subject, $object): string
    {
        $containDestination = false !== strpos($subject, self::DESTINATION_NAME);
        $containDestinationLink = false !== strpos($subject, self::DESTINATION_LINK);
        if (!$containDestination && !$containDestinationLink) {
            return $subject;
        }

        $destination = DestinationRepository::getInstance()->getById($object->getDestinationId());
        if ($containDestination) {
            $subject = str_replace(self::DESTINATION_NAME, $destination->getCountryName(), $subject);
        }

        if ($containDestinationLink) {
            $site = SiteRepository::getInstance()->getById($object->getSiteId());
            $subject = str_replace(self::DESTINATION_LINK, $site->getUrl().'/'.$destination->getCountryName().'/quote/'.$object->getId(), $subject);
        }

        return $subject;
    }
}