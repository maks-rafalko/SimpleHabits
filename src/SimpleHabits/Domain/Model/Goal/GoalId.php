<?php

namespace SimpleHabits\Domain\Model\Goal;

use Ramsey\Uuid\Uuid;

class GoalId
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
     * @param GoalId $goalId
     *
     * @return bool
     */
    public function equals(GoalId $goalId): bool
    {
        return $this->id() === $goalId->id();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->id();
    }
}
