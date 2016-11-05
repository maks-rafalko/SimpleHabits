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
    private $recordedAt;

    /**
     * GoalStep constructor.
     * @param GoalStepId $id
     * @param float|int $value
     * @param \DateTimeInterface|null
     */
    public function __construct(GoalStepId $id, $value, $recordedAt = null)
    {
        $this->id = $id;
        $this->value = $value;
        $this->recordedAt = $recordedAt ?: new \DateTimeImmutable();
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

    /**
     * @return \DateTimeInterface
     */
    public function getRecordedAt()
    {
        return $this->recordedAt;
    }
}