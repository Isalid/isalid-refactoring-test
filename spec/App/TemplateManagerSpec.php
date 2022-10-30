<?php

namespace spec\App;

use App\Entity\Quote;
use App\Entity\Template;
use App\Replacer\DestinationReplacer;
use App\Replacer\SummaryHTMLReplacer;
use App\Replacer\SummaryReplacer;
use App\Replacer\UserReplacer;
use App\TemplateManager;
use PhpSpec\ObjectBehavior;

class TemplateManagerSpec extends ObjectBehavior
{
    public function let(UserReplacer $userReplacer, DestinationReplacer $destinationReplacer, SummaryReplacer $summaryReplacer, SummaryHTMLReplacer $summaryHTMLReplacer)
    {
        $this->beConstructedWith($userReplacer, $destinationReplacer, $summaryReplacer, $summaryHTMLReplacer);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(TemplateManager::class);
    }

    // Bug on User
    public function it_compute_template(
        Template $template,
        Quote $quote,
        Template $templateComputed,
        UserReplacer $userReplacer,
        DestinationReplacer $destinationReplacer,
        SummaryReplacer $summaryReplacer,
        SummaryHTMLReplacer $summaryHTMLReplacer
    ) {
        $content = 'Bonjour [user:first_name],
            Merci de nous avoir contacté pour votre livraison à [quote:destination_name].
            Bien cordialement,
            L\'équipe de Shipper';
        $subject = 'Votre livraison à [quote:destination_name]';
        $template->getId()->willReturn(1);
        $template->getSubject()->willReturn($subject);
        $template->getContent()->willReturn($content);

        $quote->getId()->willReturn(1);
        $quote->getDestinationId()->willReturn(2);
        $quote->getDateQuoted()->willReturn(new \DateTime());
        $quote->getSiteId()->willReturn(3);

        $templateComputed->getSubject()->willReturn($subject);
        $templateComputed->getContent()->willReturn($content);
        $templateComputed->getId()->willReturn(1);

        $summaryHTMLReplacer->replace($subject, $quote)->willReturn($subject);
        $summaryHTMLReplacer->replace($content, $quote)->willReturn($content);

        $summaryReplacer->replace($subject, $quote)->willReturn($subject);
        $summaryReplacer->replace($content, $quote)->willReturn($content);

        $destinationReplacer->replace($subject, $quote)->willReturn('Votre livraison à Paris');
        $destinationReplacer->replace($content, $quote)->willReturn(
            'Bonjour [user:first_name],
            Merci de nous avoir contacté pour votre livraison à Paris.
            Bien cordialement,
            L\'équipe de Shipper'
        );

        $userReplacer->replace($subject, null)->willReturn('Votre livraison à Paris');
        $userReplacer->replace(
            'Bonjour [user:first_name],
            Merci de nous avoir contacté pour votre livraison à Paris.
            Bien cordialement,
            L\'équipe de Shipper',
            null
        )->willReturn(
            'Bonjour Maxime,
            Merci de nous avoir contacté pour votre livraison à Paris.
            Bien cordialement,
            L\'équipe de Shipper'
        );

        $templateComputed->setSubject('Votre livraison à Paris')->shouldBeCalled();
        $templateComputed->setContent(
            'Bonjour Maxime,
            Merci de nous avoir contacté pour votre livraison à Paris.
            Bien cordialement,
            L\'équipe de Shipper'
        )->shouldBeCalled();

        $this->getTemplateComputed($template, ['quote' => $quote])->shouldReturn($templateComputed);
    }
}