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

    /**
     * @test
     * @dataProvider percentageProvider
     */
    public function it_calculates_percentage($targetValue, $initialValue, $stepValue, $expectedPercentage)
    {
        $goal = $this->createGoal($targetValue, $initialValue, [['value' => $stepValue]]);

        $percentage = $goal->calculateCurrentPercentage();

        $this->assertEquals($expectedPercentage, $percentage);
    }

    public function increasingFlagDataProvider()
    {
        return [
            [0, 500, true],
            [500, 0, false],
            [0, 0, false],
        ];
    }

    public function deltaDataProvider()
    {
        return [
            [0, 1, 0.5, true],
            [0, 500, 0, true],
            [0, 500, -1, false],
            [500, 0, -1, true],
            [500, 0, 0, true],
            [500, 0, 0.5, false],
        ];
    }

    public function percentageProvider()
    {
        return [
            [6, 2, 3, 75],
            [2, 6, 3, 25],
            [2, 6, 6, 100],
            [2, 2, 6, 100],
            [2, 6, 2, 0],
            [-6, -2, -3, 75],
            [-2, -6, -3, 25],
        ];
    }

    private function createGoal($initialValue, $targetValue, array $steps = [])
    {
        $targetDate = new \DateTimeImmutable('+1 month');

        $goal = new Goal(new UserId(), new GoalId(), 'Read the book', $targetDate, $targetValue, $initialValue);

        foreach ($steps as $stepData) {
            $goal->addGoalStepWithValue($stepData['value'], $stepData['date'] ?? null);
        }

        return $goal;
    }
}
