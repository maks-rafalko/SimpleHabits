<?php

namespace SimpleHabits\Domain\Model\Goal\Exception;

use SimpleHabits\Domain\Model\Goal\GoalId;

class GoalDoesNotExistException extends \Exception
{
    /**
     * @param GoalId $id
     *
     * @return GoalDoesNotExistException
     */
    public static function withId(GoalId $id)
    {
        return new self(sprintf('Goal with id %s does not exist', $id));
    }
}
