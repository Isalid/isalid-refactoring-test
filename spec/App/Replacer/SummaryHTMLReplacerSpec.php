<?php

namespace spec\App\Replacer;

use App\Entity\Quote;
use App\Replacer\SummaryHTMLReplacer;
use PhpSpec\ObjectBehavior;

class SummaryHTMLReplacerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(SummaryHTMLReplacer::class);
    }

    public function it_replace_summary(Quote $quote)
    {
        $quote->getId()->willReturn(2);
        $subject = "Lorem ipsum ... [quote:summary_html]";
        $this->replace($subject, $quote)->shouldBe('Lorem ipsum ... <p>2</p>');
    }
}