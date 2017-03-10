<?php

namespace SimpleHabits\Domain\Model\Goal;

use SimpleHabits\Domain\Model\User\UserId;

class GoalTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider increasingFlagDataProvider
     */
    public function it_correctly_determines_increasing_flag($initialValue, $targetValue, $isIncreasing)
    {
        $goal = $this->createGoal($initialValue, $targetValue);

        $this->assertEquals($isIncreasing, $goal->isIncreasingSequence());
    }

    /**
     * @test
     * @dataProvider deltaDataProvider
     */
    public function it_should_determine_whether_delta_is_positive($initialValue, $targetValue, $delta, $isPositive)
    {
        $goal = $this->createGoal($initialValue, $targetValue);

        $this->assertEquals($isPositive, $goal->isPositiveDelta($delta));
    }

    public function increasingFlagDataProvider()
    {
        return [
            [0, 500, true],
            [500, 0, false],
        ];
    }

    public function deltaDataProvider()
    {
        return [
            [0, 500, 5, true],
            [0, 500, 0, true],
            [0, 500, -1, false],
            [500, 0, -1, true],
            [500, 0, 0, true],
            [500, 0, 1, false],
        ];
    }

    private function createGoal($initialValue, $targetValue)
    {
        $targetDate = new \DateTimeImmutable('+1 month');

        return new Goal(new UserId(), new GoalId(), 'Read the book', $targetDate, $targetValue, $initialValue);
    }
}
