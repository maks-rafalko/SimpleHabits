<?php

namespace SimpleHabits\Domain\Model\Goal;

use Doctrine\Common\Collections\ArrayCollection;
use SimpleHabits\Domain\Model\User\UserId;
use DateTimeInterface;

class Goal
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    const NAME_MIN_LENGTH = 1;
    const NAME_MAX_LENGTH = 255;

    /**
     * @var GoalId
     */
    private $id;

    /**
     * @var UserId
     */
    private $userId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \DateTimeInterface
     */
    private $startedAt;

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
     * @var int
     */
    private $status;

    /**
     * Goal constructor.
     *
     * @param UserId             $userId
     * @param GoalId             $goalId
     * @param string             $name
     * @param \DateTimeInterface $targetDate
     * @param float|int          $targetValue
     * @param float|int          $initialValue
     */
    public function __construct(UserId $userId, GoalId $goalId, $name, \DateTimeInterface $targetDate, $targetValue, $initialValue)
    {
        \Assert\that($initialValue)->notEq($targetValue);

        $this->userId = $userId;
        $this->id = $goalId;
        $this->targetValue = $targetValue;
        $this->initialValue = $initialValue;
        // TODO investigate is it ok to have only ID in a nested (not root) entity en the aggregate
        $this->goalSteps = new ArrayCollection();
        $this->status = self::STATUS_ACTIVE;
        $this->startedAt = new \DateTimeImmutable();

        $this->changeTargetDate($targetDate);
        $this->changeName($name);
    }

    /**
     * @return GoalId
     */
    public function getId() : GoalId
    {
        return $this->id;
    }

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->userId;
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
        \Assert\that($newTargetDate)->greaterOrEqualThan(new \DateTimeImmutable());

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
     * @param $value
     * @param \DateTimeInterface|null $date
     */
    public function addGoalStepWithValue($value, $date = null)
    {
        // TODO read where invariant should be guarded (in Aggregate root or in other entities)
        \Assert\that($date)
            ->nullOr()
            ->greaterOrEqualThan($this->startedAt)
            ->lessOrEqualThan(new \DateTimeImmutable());

        $this->goalSteps[] = new GoalStep(new GoalStepId(), $value, $date);
    }

    /**
     * @param string $name
     */
    public function changeName(string $name)
    {
        \Assert\that($name)
            ->notEmpty()
            ->string()
            ->minLength(self::NAME_MIN_LENGTH)
            ->maxLength(self::NAME_MAX_LENGTH);

        $this->name = $name;
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
     * @return \DateTimeInterface
     */
    public function getStartedAt() : \DateTimeInterface
    {
        return $this->startedAt;
    }

    /**
     * @return float
     */
    public function calculateAveragePerDay() : float
    {
        $interval = $this->targetDate->diff(new \DateTimeImmutable());

        $diffInDays = (int) $interval->format('%a');

        if ($diffInDays === 0) {
            return 0;
        }

        $lastRecordedValue = $this->initialValue;

        /** @var GoalStep $lastRecorderStep */
        $lastRecorderStep = $this->goalSteps->last();

        if ($lastRecorderStep) {
            $lastRecordedValue = $lastRecorderStep->getValue();
        }

        return abs($this->targetValue - $lastRecordedValue) / $diffInDays;
    }

    /**
     * @return float|int
     */
    public function getLastRecordedValue()
    {
        if ($this->goalSteps->count() === 0) {
            return $this->initialValue;
        }

        return $this->goalSteps->last()->getValue();
    }

    /**
     * @return \DateTimeInterface
     */
    public function getLastRecordedDate() : \DateTimeInterface
    {
        if ($this->goalSteps->count() === 0) {
            return $this->startedAt;
        }

        return $this->goalSteps->last()->getRecordedAt();
    }

    /**
     * @param DateTimeInterface $date
     *
     * @return float|int
     */
    public function calculateExpectedValueAt(DateTimeInterface $date)
    {
        \Assert\that($date)
            ->greaterOrEqualThan($this->startedAt)
            ->lessOrEqualThan($this->targetDate);

        $interval = $this->startedAt->diff($date);

        $diffInDays = (int) $interval->format('%a');

        $multiplier = $this->initialValue <= $this->targetValue ? 1 : -1;
        $initialAveragePerDay = $this->calculateInitialAveragePerDay();

        return $this->initialValue + ($initialAveragePerDay * $diffInDays * $multiplier);
    }

    /**
     * @param $delta
     * @return bool
     */
    public function isPositiveDelta($delta) : bool
    {
        if ($this->isIncreasingSequence()) {
            return $delta > 0;
        }

        return $delta < 0;
    }

    /**
     * @return bool
     */
    public function isIncreasingSequence() : bool
    {
        return $this->initialValue < $this->targetValue;
    }

    /**
     * @return float|int
     */
    public function calculateInitialAveragePerDay()
    {
        $interval = $this->targetDate->diff($this->startedAt);

        $diffInDays = (int) $interval->format('%a');

        if ($diffInDays === 0) {
            return 0;
        }

        return abs($this->targetValue - $this->initialValue) / $diffInDays;
    }
}
