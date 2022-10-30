<?php

namespace spec\App\Replacer;

use App\Entity\Quote;
use App\Replacer\SummaryReplacer;
use PhpSpec\ObjectBehavior;

class SummaryReplacerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(SummaryReplacer::class);
    }

    public function it_replace_summary(Quote $quote)
    {
        $quote->getId()->willReturn(2);
        $subject = "Lorem ipsum ... [quote:summary]";
        $this->replace($subject, $quote)->shouldBe('Lorem ipsum ... 2');
    }

}