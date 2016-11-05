<?php

namespace SimpleHabits\Application\Command\Goal;

use SimpleHabits\Domain\Model\Goal\GoalId;

class RemoveGoalCommand
{
    /**
     * @var GoalId
     */
    private $goalId;

    /**
     * RemoveGoalCommand constructor.
     *
     * @param GoalId $goalId
     */
    public function __construct(GoalId $goalId)
    {
        $this->goalId = $goalId;
    }

    /**
     * @return GoalId
     */
    public function getGoalId(): GoalId
    {
        return $this->goalId;
    }
}
