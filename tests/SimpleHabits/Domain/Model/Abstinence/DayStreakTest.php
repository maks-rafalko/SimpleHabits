<?php

namespace SimpleHabits\Domain\Model\Abstinence;

class DayStreakTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DayStreak
     */
    private $dayStreak;

    protected function setUp()
    {
        $startDate = new \DateTimeImmutable();
        $finishDate = new \DateTimeImmutable('+2 days');

        $this->dayStreak = new DayStreak($startDate, $finishDate);
    }

    /**
     * @test
     */
    public function it_correctly_calculate_day_streak_count()
    {
        $dayStreakCount = $this->dayStreak->getDayStreakCount();

        $this->assertEquals(2, $dayStreakCount);
    }

    /**
     * @test
     */
    public function it_correctly_returns_start_and_finish_date()
    {
        $startDate = new \DateTimeImmutable();
        $finishDate = new \DateTimeImmutable('+2 days');

        $dayStreak = new DayStreak($startDate, $finishDate);

        $this->assertEquals($dayStreak->getStartDate(), $startDate);
        $this->assertEquals($dayStreak->getFinishDate(), $finishDate);
    }
}
