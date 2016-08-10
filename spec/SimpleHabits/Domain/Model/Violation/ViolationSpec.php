<?php

namespace spec\SimpleHabits\Domain\Model\Violation;

use Assert\AssertionFailedException;
use PhpSpec\ObjectBehavior;
use SimpleHabits\Domain\Model\Violation\ViolationId;

class ViolationSpec extends ObjectBehavior
{
    const VIOLATION_REASON = 'Violation reason';

    public function let()
    {
        $this->beConstructedWith(new ViolationId(), self::VIOLATION_REASON);
    }

    public function it_should_have_an_id()
    {
        $this->getId()->shouldReturnAnInstanceOf(ViolationId::class);
    }

    public function it_has_a_violation_reason()
    {
        $this->getReason()->shouldReturn(self::VIOLATION_REASON);
    }

    public function it_can_have_no_reason()
    {
        $this->beConstructedWith();
    }

    public function it_throws_exception_when_reason_is_not_readable()
    {
        $this->beConstructedWith(new ViolationId(), []);
        $this->shouldThrow(AssertionFailedException::class)->duringInstantiation();
    }

    public function it_should_have_default_violation_date()
    {
        $this->getViolationDate()->shouldReturnAnInstanceOf(\DateTimeInterface::class);
    }

    public function it_can_have_custom_violation_date()
    {
        $violationDate = new \DateTimeImmutable();

        $this->beConstructedWith(new ViolationId(), null, $violationDate);
        $this->getViolationDate()->shouldReturn($violationDate);
    }
}
