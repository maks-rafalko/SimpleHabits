<?php

namespace spec\SimpleHabits\Domain\Model\Abstinence;

use Assert\AssertionFailedException;
use PhpSpec\ObjectBehavior;

class DayStreakSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(new \DateTimeImmutable('-2 days'), new \DateTimeImmutable());
    }

    public function it_should_have_a_day_streak_start_date()
    {
        $this->getStartDate()->shouldReturnAnInstanceOf(\DateTimeInterface::class);
    }

    public function it_should_have_a_day_streak_finish_date()
    {
        $this->getFinishDate()->shouldReturnAnInstanceOf(\DateTimeInterface::class);
    }

    public function it_should_have_a_count_of_days_in_current_streak()
    {
        $this->getDayStreakCount()->shouldReturn(2);
    }

    public function it_throws_an_exception_when_start_date_more_than_current_date()
    {
        $this->beConstructedWith(new \DateTimeImmutable('+2 days'), new \DateTimeImmutable());
        $this->shouldThrow(AssertionFailedException::class)->duringInstantiation();
    }

    public function it_throws_an_exception_when_start_date_more_than_finish_date()
    {
        $this->beConstructedWith(new \DateTimeImmutable('-1 day'), new \DateTimeImmutable('-2 days'));
        $this->shouldThrow(AssertionFailedException::class)->duringInstantiation();
    }
}
