<?php

namespace App;

use App\Context\ApplicationContext;
use App\Entity\Quote;
use App\Entity\Template;
use App\Entity\User;
use App\Helper\TemplateHelper;
use App\Repository\DestinationRepository;
use App\Repository\QuoteRepository;
use App\Repository\SiteRepository;

class TemplateManager
{
    private QuoteRepository $quoteRepository;
    private SiteRepository $siteRepository;
    private DestinationRepository $destinationRepository;
    private TemplateHelper $templateHelper;
    private ApplicationContext $applicationContext;

    public function __construct(
        ApplicationContext $applicationContext,
        QuoteRepository $quoteRepository,
        SiteRepository $siteRepository,
        DestinationRepository $destinationRepository,
        TemplateHelper $templateHelper
    ) {
        $this->applicationContext = $applicationContext;
        $this->quoteRepository = $quoteRepository;
        $this->siteRepository = $siteRepository;
        $this->destinationRepository = $destinationRepository;
        $this->templateHelper = $templateHelper;
    }

    public function getTemplateComputed(Template $tpl, array $data)
    {
        if (!array_key_exists('quote', $data) && !$data['quote'] instanceof Quote) {
            throw new \RuntimeException('key quote is mandatory and must be a Quote.');
        }

        $quote = $data['quote'];
        $user = null;
        if (array_key_exists('user', $data) && $data['user'] instanceof User) {
            $user = $data['user'];
        }

        $subject = $this->computeText($tpl->getSubject(), $quote, $user);
        $content = $this->computeText($tpl->getContent(), $quote, $user);

        return new Template($tpl->getId(), $subject, $content);
    }

    private function computeText($text, Quote $quote, ?User $user): string
    {
        $containsSummaryHtml = strpos($text, '[quote:summary_html]');
        $containsSummary     = strpos($text, '[quote:summary]');
        if ($containsSummaryHtml !== false) {
            $text = str_replace('[quote:summary_html]', Quote::renderHtml($quote), $text);
        }
        if ($containsSummary !== false) {
            $text = str_replace('[quote:summary]', Quote::renderText($quote), $text);
        }

        if ($this->templateHelper->checkForParam('[quote:destination_name]', $text)) {
            $text = str_replace('[quote:destination_name]', $quote->getDestination()->getCountryName(), $text);
        }

        $link = '';
        if ($this->templateHelper->checkForParam('[quote:destination_link]', $text)) {
            $link = sprintf(
                '%s/%s/quote/%s',
                $quote->getSite()->getUrl(),
                $quote->getDestination()->getCountryName(),
                $quote->getId()
            );
        }
        $text = str_replace('[quote:destination_link]', $link, $text);
        $user = $user ?? $this->applicationContext->getCurrentUser();
        if ($this->templateHelper->checkForParam('[user:first_name]', $text)) {
            $text = str_replace('[user:first_name]', ucfirst(mb_strtolower($user->getFirstname())), $text);
        }

        return $text;
    }
}
