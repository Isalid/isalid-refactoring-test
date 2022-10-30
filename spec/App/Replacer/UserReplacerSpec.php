<?php


namespace spec\App\Replacer;


use App\Context\ApplicationContext;
use App\Entity\User;
use App\Replacer\UserReplacer;
use Faker\Generator;
use PhpSpec\ObjectBehavior;

class UserReplacerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(UserReplacer::class);
    }

    // bug because of random
    public function it_replace_user_firstname(ApplicationContext $applicationContext, User $user)
    {
        $subject = 'Bonjour [user:first_name]';
        $user->getId()->willReturn(2);
        $user->getFirstname()->willReturn('Stanford');

        $applicationContext->getCurrentUser()->willReturn($user);

        $this->replace($subject, null)->shouldBe('Bonjour Stanford');
    }
}