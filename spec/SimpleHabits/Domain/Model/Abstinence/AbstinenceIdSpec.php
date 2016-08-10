<?php

namespace spec\SimpleHabits\Domain\Model\Abstinence;

use PhpSpec\ObjectBehavior;
use SimpleHabits\Domain\Model\Abstinence\AbstinenceId;

class AbstinenceIdSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(AbstinenceId::class);
    }
}
