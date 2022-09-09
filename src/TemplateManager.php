<?php

namespace Isalid;

use Isalid\Entity\Template;
use Isalid\Shortcode\QuoteShortcodeReplacer;
use Isalid\Shortcode\ShortcodeReplacer;
use Isalid\Shortcode\UserShortcodeReplacer;

class TemplateManager
{
    private $shortcodeReplacers = [];

    public function __construct(array $shortcodeReplacers = [])
    {
        $this->shortcodeReplacers = $shortcodeReplacers;

        if (count($shortcodeReplacers) === 0) {
            $this->shortcodeReplacers = [
                new QuoteShortcodeReplacer(),
                new UserShortcodeReplacer()
            ];
        }
    }

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
        foreach ($this->shortcodeReplacers as $shortcodeReplacer) {
            /** @var ShortcodeReplacer $shortcodeReplacer */
            $text = $shortcodeReplacer->replace($text, $data);
        }

        return $text;
    }
}
