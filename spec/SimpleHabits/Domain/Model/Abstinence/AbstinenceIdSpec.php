<?php

namespace spec\SimpleHabits\Domain\Model\Abstinence;

use SimpleHabits\Domain\Model\Abstinence\AbstinenceId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AbstinenceIdSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AbstinenceId::class);
    }
}
