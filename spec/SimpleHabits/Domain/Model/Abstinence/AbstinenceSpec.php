<?php

declare(strict_types=1);

namespace spec\SimpleHabits\Domain\Model\Abstinence;

use Assert\AssertionFailedException;
use PhpSpec\ObjectBehavior;
use SimpleHabits\Domain\Model\Abstinence\AbstinenceId;
use SimpleHabits\Domain\Model\Abstinence\DayStreak;
use SimpleHabits\Domain\Model\Violation\Violation;

class AbstinenceSpec extends ObjectBehavior
{
    const NAME = 'Do not smoke';
    const NEW_NAME = 'Do not lie';

    public function let()
    {
        $this->beConstructedWith(new AbstinenceId(), self::NAME);
    }

    public function it_should_have_an_id()
    {
        $this->getId()->shouldReturnAnInstanceOf(AbstinenceId::class);
    }

    public function it_has_a_name()
    {
        $this->getName()->shouldEqual(self::NAME);
    }

    public function it_has_a_start_date()
    {
        $this->getStartedAt()->shouldReturnAnInstanceOf(\DateTimeInterface::class);
    }

    public function it_should_change_name()
    {
        $this->getName()->shouldEqual(self::NAME);
        $this->changeName(self::NEW_NAME);
        $this->getName()->shouldEqual(self::NEW_NAME);
    }

    public function it_should_change_start_date()
    {
        $newStartDate = new \DateTimeImmutable('-3 days');
        $this->changeStartDate($newStartDate);
        $this->getStartedAt()->shouldBeLike($newStartDate);
    }

    public function it_throws_an_exception_when_start_date_changed_to_the_future()
    {
        $newStartDate = new \DateTimeImmutable('+3 days');
        $this->shouldThrow(AssertionFailedException::class)->during('changeStartDate', [$newStartDate]);
    }

    public function it_is_active_by_default()
    {
        $this->isActive()->shouldReturn(true);
    }

    public function it_can_be_deleted()
    {
        $this->delete();
        $this->isDeleted()->shouldReturn(true);
    }

    public function it_throws_an_exception_when_name_is_empty()
    {
        $this->beConstructedWith(new AbstinenceId(), '');
        $this->shouldThrow(AssertionFailedException::class)->duringInstantiation();
    }

    public function it_can_be_violated()
    {
        $this->isViolated()->shouldReturn(false);
        $this->violate();
        $this->isViolated()->shouldReturn(true);
    }

    public function it_can_be_violated_with_a_reason()
    {
        $this->violate('Reason');
        $this->getViolations()[0]->getReason()->shouldReturn('Reason');
    }

    public function it_can_be_violated_with_a_reason_and_date()
    {
        $violationDate = new \DateTimeImmutable('2 days ago');

        $this->violate('Reason', $violationDate);
        $this->getViolations()[0]->getViolationDate()->shouldBeLike($violationDate);
    }

    public function it_can_return_last_violation()
    {
        $this->violate('Reason', new \DateTimeImmutable('2 days ago'));
        $this->getLastViolation()->shouldReturnAnInstanceOf(Violation::class);
    }

    public function it_should_calculate_day_streak_with_no_violations()
    {
        $this->calculateDayStreak()->shouldReturnAnInstanceOf(DayStreak::class);
    }

    public function it_should_calculate_day_streak_with_violations()
    {
        $this->violate();
        $this->calculateDayStreak()->shouldReturnAnInstanceOf(DayStreak::class);
    }
}
