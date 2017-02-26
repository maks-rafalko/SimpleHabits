<?php

namespace SimpleHabits\Domain\Model\Goal;

use Ramsey\Uuid\Uuid;

class GoalStepId
{
    /**
     * @var string
     */
    private $id;

    /**
     * @param string $id
     */
    public function __construct($id = null)
    {
        $this->id = null === $id ? Uuid::uuid4()->toString() : $id;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @param GoalStepId $goalStepId
     *
     * @return bool
     */
    public function equals(GoalStepId $goalStepId): bool
    {
        return $this->id() === $goalStepId->id();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->id();
    }
}
