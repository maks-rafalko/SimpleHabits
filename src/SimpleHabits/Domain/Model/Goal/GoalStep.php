<?php

namespace SimpleHabits\Domain\Model\Goal;

/**
 * Class GoalStep
 */
class GoalStep
{
    /**
     * @var GoalStepId
     */
    private $id;
    
    /**
     * @var float|int
     */
    private $value;

    /**
     * @var \DateTimeInterface
     */
    private $recorderAt;

    /**
     * GoalStep constructor.
     * @param GoalStepId $id
     * @param float|int $value
     */
    public function __construct(GoalStepId $id, $value)
    {
        $this->id = $id;
        $this->value = $value;
        $this->recorderAt = new \DateTimeImmutable();
    }

    /**
     * @return GoalStepId
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return float|int
     */
    public function getValue()
    {
        return $this->value;
    }
}