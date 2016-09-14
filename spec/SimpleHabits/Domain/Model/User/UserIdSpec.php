<?php

namespace spec\SimpleHabits\Domain\Model\User;

use PhpSpec\ObjectBehavior;
use SimpleHabits\Domain\Model\User\UserId;

class UserIdSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(UserId::class);
    }
}
