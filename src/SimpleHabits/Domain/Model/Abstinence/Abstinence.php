<?php

declare(strict_types=1);

namespace SimpleHabits\Domain\Model\Abstinence;

use Doctrine\Common\Collections\ArrayCollection;
use SimpleHabits\Domain\Model\User\UserId;
use SimpleHabits\Domain\Model\Violation\Violation;
use SimpleHabits\Domain\Model\Violation\ViolationId;

class Abstinence
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    const NAME_MIN_LENGTH = 1;
    const NAME_MAX_LENGTH = 255;

    /**
     * @var AbstinenceId
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
     * @var int
     */
    private $status;

    /**
     * @var \DateTimeInterface
     */
    private $startedAt;

    /**
     * @var ArrayCollection
     */
    private $violations;

    /**
     * Abstinence constructor.
     *
     * @param UserId       $userId
     * @param AbstinenceId $id
     * @param string       $name
     */
    public function __construct(UserId $userId, AbstinenceId $id, string $name)
    {
        $this->changeName($name);

        $this->userId = $userId;
        $this->id = $id;
        $this->status = self::STATUS_ACTIVE;
        $this->startedAt = new \DateTimeImmutable();
        $this->violations = new ArrayCollection();
    }

    /**
     * @return AbstinenceId
     */
    public function getId(): AbstinenceId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->status === self::STATUS_DELETED;
    }

    /**
     * Mark this abstinence as deleted.
     */
    public function delete()
    {
        $this->status = self::STATUS_DELETED;
    }

    /**
     * @param null $reason
     * @param null $violatedAt
     */
    public function violate($reason = null, $violatedAt = null)
    {
        $this->violations[] = new Violation(new ViolationId(), $reason, $violatedAt);
    }

    /**
     * @return bool
     */
    public function isViolated(): bool
    {
        return count($this->violations) > 0;
    }

    /**
     * @return array
     */
    public function getViolations(): array
    {
        return $this->violations->toArray();
    }

    /**
     * @return DayStreak
     */
    public function calculateDayStreak(): DayStreak
    {
        if (count($this->violations) === 0) {
            return new DayStreak($this->startedAt, new \DateTimeImmutable());
        }

        /** @var Violation $lastViolation */
        $lastViolation = $this->getLastViolation();

        return new DayStreak($lastViolation->getViolationDate(), new \DateTimeImmutable());
    }

    /**
     * @return DayStreak
     */
    public function calculateLongestStreak(): DayStreak
    {
        // TODO read where such functions should be stored. Read about Repository
        if (count($this->violations) === 0) {
            return new DayStreak($this->startedAt, new \DateTimeImmutable());
        }

        $intervals = $this->getAllDateStreaks();

        usort(
            $intervals,
            function (DayStreak $dayStreakA, DayStreak $dayStreakB) {
                $aCount = $dayStreakA->getDayStreakCount();
                $bCount = $dayStreakB->getDayStreakCount();

                if ($aCount === $bCount) {
                    return 0;
                }

                return $aCount > $bCount ? -1 : 1;
            }
        );

        return $intervals[0];
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
     * @param \DateTimeInterface $newStartDate
     */
    public function changeStartDate(\DateTimeInterface $newStartDate)
    {
        \Assert\that($newStartDate)->lessOrEqualThan(new \DateTimeImmutable());

        $this->startedAt = $newStartDate;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getStartedAt(): \DateTimeInterface
    {
        return $this->startedAt;
    }

    /**
     * @return mixed
     */
    public function getLastViolation(): Violation
    {
        return $this->violations->last();
    }

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->userId;
    }

    /**
     * Get all date streaks (intervals) between start date, violations date, and current date
     * They will be used to calculate the longest day streak.
     *
     * @return array
     */
    private function getAllDateStreaks(): array
    {
        $periodDates = [$this->startedAt];

        $periodDates = array_merge(
            $periodDates,
            array_map(
                function (Violation $violation) {
                    return $violation->getViolationDate();
                },
                $this->violations->toArray()
            )
        );

        $periodDates[] = new \DateTimeImmutable();

        $dayStreakCount = count($periodDates) - 1;
        $dayStreaks = [];

        for ($index = 0; $index < $dayStreakCount; ++$index) {
            $dayStreaks[] = new DayStreak($periodDates[$index], $periodDates[$index + 1]);
        }

        return $dayStreaks;
    }
}
