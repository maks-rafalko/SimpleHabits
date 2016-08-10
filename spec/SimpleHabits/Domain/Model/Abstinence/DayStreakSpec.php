<?php

namespace spec\SimpleHabits\Domain\Model\Abstinence;

use SimpleHabits\Domain\Model\Abstinence\DayStreak;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

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

    public function it_should_have_a_count_of_days_in_current_streak()
    {
        $this->getDayStreakCount()->shouldReturn(2);
    }
}
