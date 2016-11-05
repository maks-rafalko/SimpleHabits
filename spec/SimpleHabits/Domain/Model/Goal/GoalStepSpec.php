<?php

namespace spec\SimpleHabits\Domain\Model\Goal;

use PhpSpec\ObjectBehavior;
use SimpleHabits\Domain\Model\Goal\GoalStepId;

class GoalStepSpec extends ObjectBehavior
{
    const STEP_VALUE = 90;

    public function let()
    {
        $this->beConstructedWith(
            new GoalStepId(),
            self::STEP_VALUE
        );
    }

    public function it_should_have_a_value()
    {
        $this->getValue()->shouldEqual(self::STEP_VALUE);
    }
}
