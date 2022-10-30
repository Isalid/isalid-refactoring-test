<?php

namespace spec\App\Replacer;

use App\Entity\Destination;
use App\Entity\Quote;
use App\Entity\Site;
use App\Replacer\DestinationReplacer;
use App\Repository\DestinationRepository;
use App\Repository\SiteRepository;
use PhpSpec\ObjectBehavior;

class DestinationReplacerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(DestinationReplacer::class);
    }

    public function it_replace_destination_name(Quote $quote, Destination $destination, DestinationRepository $destinationRepository)
    {
        $faker = \Faker\Factory::create();

        $quote->getDestinationId()->willReturn(37);

        $destinationRepository->getById(37)->willReturn($destination);
        $destination->getCountryName()->willReturn('Colombia');

        $subject = 'Votre livraison à [quote:destination_name]';

        $this->replace($subject, $quote)->shouldBe('Votre livraison à Colombia');
    }

    public function it_replace_destination_link(Quote $quote, Destination $destination, DestinationRepository $destinationRepository, SiteRepository $siteRepository, Site $site)
    {
        $quote->getDestinationId()->willReturn(37);
        $quote->getSiteId()->willReturn(1);
        $quote->getId()->willReturn(2);
        $destinationRepository->getById(37)->willReturn($destination);
        $destination->getCountryName()->willReturn('Colombia');
        $siteRepository->getById(1)->willReturn($site);
        $site->getUrl()->willReturn('http');

        $subject = "<a href='[quote:destination_link]'/>destination</a>";

        $this->replace($subject, $quote)->shouldBe("<a href='http://www.kassulke.com/rerum-quaerat-ut-fuga-non-quibusdam-itaque-ut.html/Colombia/quote/2'/>destination</a>");
    }
}