<?php

namespace Isalid;

use Isalid\Context\ApplicationContext;
use Isalid\Entity\Quote;
use Isalid\Entity\Template;
use Isalid\Entity\User;
use Isalid\Repository\DestinationRepository;
use Isalid\Repository\QuoteRepository;
use Isalid\Repository\SiteRepository;
use Isalid\Shortcode\QuoteShortcodeReplacer;
use Isalid\Shortcode\ShortcodeReplacer;
use Isalid\Shortcode\UserShortcodeReplacer;

class TemplateManager
{
    public function getTemplateComputed(Template $tpl, array $data)
    {
        if (!$tpl) {
            throw new \RuntimeException('no tpl given');
        }

        $replaced = clone($tpl);
        $replaced->subject = $this->computeText($replaced->subject, $data);
        $replaced->content = $this->computeText($replaced->content, $data);

        return $replaced;
    }

    private function computeText($text, array $data)
    {
        $shortcodeReplacers = [
            new QuoteShortcodeReplacer(),
            new UserShortcodeReplacer()
        ];

        foreach ($shortcodeReplacers as $shortcodeReplacer) {
            /** @var ShortcodeReplacer $shortcodeReplacer */
            $text = $shortcodeReplacer->replace($text, $data);
        }

        return $text;
    }
}
