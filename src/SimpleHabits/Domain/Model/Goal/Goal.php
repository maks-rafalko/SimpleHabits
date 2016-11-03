<?php

namespace SimpleHabits\Domain\Model\Goal;

use Doctrine\Common\Collections\ArrayCollection;

class Goal
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @var GoalId
     */
    private $goalId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \DateTimeInterface
     */
    private $targetDate;

    /**
     * @var float
     */
    private $targetValue;

    /**
     * @var float
     */
    private $initialValue;

    /**
     * @var ArrayCollection
     */
    private $goalSteps;

    /**
     * @var float
     */
    private $averagePerDay = 0;

    /**
     * @var int
     */
    private $status;

    /**
     * Goal constructor.
     * @param GoalId $goalId
     * @param string $name
     * @param \DateTimeInterface $targetDate
     * @param float|int $targetValue
     * @param float|int $initialValue
     */
    public function __construct(GoalId $goalId, $name, \DateTimeInterface $targetDate, $targetValue, $initialValue)
    {
        $this->goalId = $goalId;
        $this->name = $name;
        $this->targetDate = $targetDate;
        $this->targetValue = $targetValue;
        $this->initialValue = $initialValue;
        $this->goalSteps = new ArrayCollection();
        $this->status = self::STATUS_ACTIVE;

        $this->calculateAveragePerDay();
    }

    /**
     * @return GoalId
     */
    public function getId() : GoalId
    {
        return $this->goalId;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param \DateTimeInterface $newTargetDate
     */
    public function changeTargetDate(\DateTimeInterface $newTargetDate)
    {
        $this->targetDate = $newTargetDate;
    }

    /**
     * @param $newTargetValue
     */
    public function changeTargetValue($newTargetValue)
    {
        $this->targetValue = $newTargetValue;
    }

    /**
     * @return array
     */
    public function getGoalSteps() : array
    {
        return $this->goalSteps->toArray();
    }

    /**
     * @return float
     */
    public function getAveragePerDay() : float
    {
        return $this->averagePerDay;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getTargetDate() : \DateTimeInterface
    {
        return $this->targetDate;
    }

    /**
     * @return float|int
     */
    public function getTargetValue()
    {
        return $this->targetValue;
    }

    /**
     * @return float|int
     */
    public function getInitialValue()
    {
        return $this->initialValue;
    }

    /**
     * @param $newInitialValue
     */
    public function changeInitialValue($newInitialValue)
    {
        $this->initialValue = $newInitialValue;
    }

    /**
     * @param float|int
     */
    public function addGoalStepWithValue($value)
    {
        $this->goalSteps[] = new GoalStep(new GoalStepId(), $value);
    }

    /**
     * Mark this abstinence as deleted.
     */
    public function delete()
    {
        $this->status = self::STATUS_DELETED;
    }

    /**
     * @return bool
     */
    public function isDeleted() : bool
    {
        return $this->status === self::STATUS_DELETED;
    }

    /**
     * @return bool
     */
    public function isActive() : bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * @return float
     */
    private function calculateAveragePerDay() : float
    {
        $interval = $this->targetDate->diff(new \DateTimeImmutable());

        $diffInDays = (int) $interval->format('%a');

        if ($diffInDays === 0) {
            return 0;
        }

        // TODO initial value -> get from steps last value

        return $this->averagePerDay = abs($this->targetValue - $this->initialValue) / $diffInDays;
    }
}
