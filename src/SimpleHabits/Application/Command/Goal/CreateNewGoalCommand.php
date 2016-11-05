<?php

namespace SimpleHabits\Application\Command\Goal;


use SimpleHabits\Domain\Model\User\UserId;

class CreateNewGoalCommand
{
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
     * CreateNewGoalCommand constructor.
     * @param UserId $userId
     * @param string $name
     * @param \DateTimeInterface $targetDate
     * @param float $targetValue
     * @param float $initialValue
     */
    public function __construct(UserId $userId, string $name, \DateTimeInterface $targetDate, $targetValue, $initialValue)
    {
        $this->userId = $userId;
        $this->name = $name;
        $this->targetDate = $targetDate;
        $this->targetValue = $targetValue;
        $this->initialValue = $initialValue;
    }

    /**
     * @return UserId
     */
    public function getUserId() : UserId
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
     * @return \DateTimeInterface
     */
    public function getTargetDate() : \DateTimeInterface
    {
        return $this->targetDate;
    }

    /**
     * @return float
     */
    public function getTargetValue()
    {
        return $this->targetValue;
    }

    /**
     * @return float
     */
    public function getInitialValue()
    {
        return $this->initialValue;
    }
}