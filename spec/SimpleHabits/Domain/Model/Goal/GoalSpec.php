<?php

namespace spec\SimpleHabits\Domain\Model\Goal;

use PhpSpec\ObjectBehavior;
use SimpleHabits\Domain\Model\Goal\GoalId;
use SimpleHabits\Domain\Model\Goal\GoalStep;
use SimpleHabits\Domain\Model\Goal\GoalStepId;

class GoalSpec extends ObjectBehavior
{
    const TARGET_VALUE = 70;
    const INITIAL_VALUE = 100;

    const NAME = 'Loose weight';

    public function let()
    {
        $targetDate = new \DateTimeImmutable('+15 days');

        $this->beConstructedWith(
            new GoalId(),
            self::NAME,
            $targetDate,
            self::TARGET_VALUE,
            self::INITIAL_VALUE
        );
    }

    public function it_should_have_an_id()
    {
        $this->getId()->shouldReturnAnInstanceOf(GoalId::class);
    }

    public function it_has_a_name()
    {
        $this->getName()->shouldEqual(self::NAME);
    }

    public function it_has_a_start_date()
    {
        $this->getStartedAt()->shouldReturnAnInstanceOf(\DateTimeInterface::class);
    }

    public function it_has_a_target_date()
    {
        $this->getTargetDate()->shouldReturnAnInstanceOf(\DateTimeImmutable::class);
    }

    public function it_should_change_target_date()
    {
        $newStartDate = new \DateTimeImmutable('+2 months');
        $this->changeTargetDate($newStartDate);
        $this->getTargetDate()->shouldBeLike($newStartDate);
    }

    public function it_has_a_target_value()
    {
        $this->getTargetValue()->shouldEqual(self::TARGET_VALUE);
    }

    public function it_should_change_target_value()
    {
        $newTargetValue = 68;
        $this->changeTargetValue($newTargetValue);
        $this->getTargetValue()->shouldBeLike($newTargetValue);
    }

    public function it_has_an_initial_value()
    {
        $this->getInitialValue()->shouldEqual(self::INITIAL_VALUE);
    }

    public function it_should_change_initial_value()
    {
        $newInitialValue = 68;
        $this->changeInitialValue($newInitialValue);
        $this->getInitialValue()->shouldBeLike($newInitialValue);
    }

    public function it_has_no_goal_steps_by_default()
    {
        $this->getGoalSteps()->shouldHaveCount(0);
    }

    public function it_should_have_calculated_average_per_day_value()
    {
        $this->calculateAveragePerDay()->shouldEqual(2.0);
    }

    public function it_can_add_goal_step()
    {
        $this->addGoalStepWithValue(90);
        $this->getGoalSteps()->shouldHaveCount(1);
    }

    public function it_can_add_goal_step_with_particular_date()
    {
        // TODO add check that date is not less than created at
        $date = new \DateTimeImmutable('+1 minute');

        $this->addGoalStepWithValue(90, $date);
        $this->getViolations()[0]->getRecorderAt()->shouldBeLike($date);
    }

    public function it_should_take_last_recorded_value_from_the_last_step()
    {
        $this->addGoalStepWithValue(85);
        $this->calculateAveragePerDay()->shouldEqual(1.0);
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
}
