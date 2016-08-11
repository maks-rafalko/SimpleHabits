<?php

declare(strict_types=1);

namespace SimpleHabits\Domain\Model\Abstinence;

class DayStreak
{
    /**
     * @var \DateTimeInterface
     */
    private $startDate;

    /**
     * @var \DateTimeInterface
     */
    private $finishDate;

    /**
     * DayStreak constructor.
     *
     * @param \DateTimeInterface $startDate
     * @param \DateTimeInterface $finishDate
     */
    public function __construct(\DateTimeInterface $startDate, \DateTimeInterface $finishDate)
    {
        \Assert\that($startDate)->lessOrEqualThan(new \DateTimeImmutable());
        \Assert\that($startDate)->lessOrEqualThan($finishDate);

        $this->startDate = $startDate;
        $this->finishDate = $finishDate;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getStartDate() : \DateTimeInterface
    {
        return $this->startDate;
    }

    /**
     * @return int
     */
    public function getDayStreakCount() : int
    {
        $interval = $this->finishDate->diff($this->startDate);

        return (int) $interval->format('%a');
    }
}
