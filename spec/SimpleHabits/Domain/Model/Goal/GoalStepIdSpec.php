<?php

namespace spec\SimpleHabits\Domain\Model\Goal;

use SimpleHabits\Domain\Model\Goal\GoalStepId;
use PhpSpec\ObjectBehavior;

class GoalStepIdSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(GoalStepId::class);
    }
}
