<?php

namespace SimpleHabits\Domain\Model\Abstinence\Exception;

use SimpleHabits\Domain\Model\Abstinence\AbstinenceId;

class AbstinenceDoesNotExistException extends \Exception
{
    /**
     * @param AbstinenceId $id
     *
     * @return AbstinenceDoesNotExistException
     */
    public static function withId(AbstinenceId $id)
    {
        return new self(sprintf('User with id %s does not exist', $id));
    }
}
