<?php

namespace spec\SimpleHabits\Domain\Model\Goal;

use SimpleHabits\Domain\Model\Goal\GoalId;
use PhpSpec\ObjectBehavior;

class GoalIdSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(GoalId::class);
    }
}
