<?php

namespace SimpleHabits\Application\Command\Goal;

use SimpleHabits\Domain\Model\Goal\GoalId;

class AddGoalStepCommand
{
    /**
     * @var GoalId
     */
    private $goalId;

    /**
     * @var float|int
     */
    private $value;

    /**
     * @var \DateTimeInterface
     */
    private $date;

    /**
     * AddGoalStepCommand constructor.
     *
     * @param GoalId                  $goalId
     * @param float|int               $value
     * @param \DateTimeInterface|null $date
     */
    public function __construct(GoalId $goalId, $value, \DateTimeInterface $date = null)
    {
        $this->goalId = $goalId;
        $this->value = $value;
        $this->date = $date;
    }

    /**
     * @return GoalId
     */
    public function getGoalId()
    {
        return $this->goalId;
    }

    /**
     * @return float|int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDate()
    {
        return $this->date;
    }
}
