<?php

namespace spec\SimpleHabits\Domain\Model\Violation;

use PhpSpec\ObjectBehavior;
use SimpleHabits\Domain\Model\Violation\ViolationId;

class ViolationIdSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(ViolationId::class);
    }
}
