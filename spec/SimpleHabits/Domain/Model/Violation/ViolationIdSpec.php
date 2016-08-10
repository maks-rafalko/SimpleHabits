<?php

namespace spec\SimpleHabits\Domain\Model\Violation;

use SimpleHabits\Domain\Model\Violation\ViolationId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ViolationIdSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ViolationId::class);
    }
}
