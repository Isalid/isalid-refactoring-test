<?php

declare(strict_types=1);

class QuoteProcessor extends AbstractTemplateProcessor
{
    private QuoteRepository $quoteRepository;
    private SiteRepository $siteRepository;
    private DestinationRepository $destinationRepository;

    public function __construct(
        QuoteRepository $quoteRepository,
        SiteRepository $siteRepository,
        DestinationRepository $destinationRepository
    ) {
        $this->quoteRepository = $quoteRepository;
        $this->siteRepository = $siteRepository;
        $this->destinationRepository = $destinationRepository;
    }

    public function process(string $text, $entity): string
    {
        if (!$entity instanceof Quote) {
            $text = $this->replace($text, 'destination_link', '');

            return $text;
        }

        $quote = $this->quoteRepository->getById($entity->id);
        $site = $this->siteRepository->getById($entity->siteId);
        $destination = $this->destinationRepository->getById($entity->destinationId);

        $text = $this->replaces(
            $text,
            [
                'summary_html' => Quote::renderHtml($quote),
                'summary' => Quote::renderText($quote),
                'destination_name' => $destination->countryName,
                'destination_link' => $site->url . '/' . $destination->countryName . '/quote/' . $quote->id,
            ]
        );

        return $text;
    }

    protected function getPrefix(): string
    {
        return 'quote';
    }
}
