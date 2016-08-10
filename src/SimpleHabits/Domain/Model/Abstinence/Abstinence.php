<?php

declare(strict_types=1);

namespace SimpleHabits\Domain\Model\Abstinence;

use SimpleHabits\Domain\Model\Violation\Violation;
use SimpleHabits\Domain\Model\Violation\ViolationId;

class Abstinence
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    const NAME_MIN_LENGTH = 0;
    const NAME_MAX_LENGTH = 255;

    /**
     * @var AbstinenceId
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $status;

    /**
     * @var \DateTimeImmutable
     */
    private $startedAt;

    /**
     * @var array
     */
    private $violations = [];

    /**
     * Abstinence constructor.
     *
     * @param AbstinenceId $id
     * @param string       $name
     */
    public function __construct(AbstinenceId $id, string $name)
    {
        $this->changeName($name);

        $this->id = $id;
        $this->status = self::STATUS_ACTIVE;
        $this->startedAt = new \DateTimeImmutable();
    }

    /**
     * @return AbstinenceId
     */
    public function getId() : AbstinenceId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isActive() : bool
    {
        return $this->status === self::STATUS_ACTIVE;
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
    public function isViolated() : bool
    {
        return count($this->violations) > 0;
    }

    /**
     * @return array
     */
    public function getViolations() : array
    {
        return $this->violations;
    }

    /**
     * @return DayStreak
     */
    public function calculateDayStreak() : DayStreak
    {
        if (count($this->violations) === 0) {
            return new DayStreak($this->startedAt, new \DateTimeImmutable());
        }

        /** @var Violation $lastViolation */
        $lastViolation = end($this->violations);

        return new DayStreak($lastViolation->getViolationDate(), new \DateTimeImmutable());
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
}
