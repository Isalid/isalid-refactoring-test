<?php

namespace App;

use App\Entity\Template;
use App\Entity\User;
use App\Entity\Quote;
use App\Replacer\DestinationReplacer;
use App\Replacer\SummaryHTMLReplacer;
use App\Replacer\SummaryReplacer;
use App\Replacer\UserReplacer;

class TemplateManager
{
    private $quote;
    private $user;
    private UserReplacer $userProcessor;
    private DestinationReplacer $destinationReplacer;
    private SummaryReplacer $summaryReplacer;
    private SummaryHTMLReplacer $summaryHTMLReplacer;

    public function __construct(
        UserReplacer $userProcessor,
        DestinationReplacer $destinationReplacer,
        SummaryReplacer $summaryReplacer,
        SummaryHTMLReplacer $summaryHTMLReplacer
    ) {
        $this->userProcessor = $userProcessor;
        $this->destinationReplacer = $destinationReplacer;
        $this->summaryReplacer = $summaryReplacer;
        $this->summaryHTMLReplacer = $summaryHTMLReplacer;
    }

    public function getTemplateComputed(Template $tpl, array $data)
    {
        $clonedTemplate = clone($tpl);
        $quote = (isset($data['quote']) && $data['quote'] instanceof Quote) ? $data['quote'] : null;
        $user = (isset($data['user']) && $data['user'] instanceof User) ? $data['user'] : null;
        if (!$quote instanceof Quote) {
            return $clonedTemplate;
        }
        $this->quote = $quote;
        $this->user = $user;

        $this->processSubject($clonedTemplate);
        $this->processContent($clonedTemplate);

        return $clonedTemplate;
    }

    private function processSubject(Template $template): void
    {
        $subject = $template->getSubject();
        $subject = $this->summaryHTMLReplacer->replace($subject, $this->quote);
        $subject = $this->summaryReplacer->replace($subject, $this->quote);
        $subject = $this->destinationReplacer->replace($subject, $this->quote);
        $subject = $this->userProcessor->replace($subject, $this->user);

        $template->setSubject($subject);
    }

    private function processContent(Template $template): void
    {
        $content = $template->getContent();
        $content = $this->summaryHTMLReplacer->replace($content, $this->quote);
        $content = $this->summaryReplacer->replace($content, $this->quote);
        $content = $this->destinationReplacer->replace($content, $this->quote);
        $content = $this->userProcessor->replace($content, $this->user);

        $template->setContent($content);
    }
}
