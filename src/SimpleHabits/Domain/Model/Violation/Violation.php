<?php

namespace SimpleHabits\Domain\Model\Violation;

use SimpleHabits\Domain\Model\Abstinence\AbstinenceId;

class Violation
{
    const MAX_REASON_LENGTH = 255;

    /**
     * @var ViolationId
     */
    private $id;

    /**
     * @var null|string
     */
    private $reason;

    /**
     * @var \DateTimeInterface
     */
    private $violatedAt;

    /**
     * @var AbstinenceId
     */
    private $abstinenceId;

    /**
     * Violation constructor.
     *
     * @param ViolationId             $id
     * @param AbstinenceId            $abstinenceId
     * @param null|string             $reason
     * @param null|\DateTimeInterface $violatedAt
     */
    public function __construct(ViolationId $id, AbstinenceId $abstinenceId, $reason = null, $violatedAt = null)
    {
        \Assert\that($reason)->nullOr()->string()->maxLength(self::MAX_REASON_LENGTH);

        $this->id = $id;
        $this->abstinenceId = $abstinenceId;
        $this->reason = $reason;
        $this->violatedAt = $violatedAt ?: new \DateTimeImmutable();
    }

    /**
     * @return ViolationId
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getViolationDate()
    {
        return $this->violatedAt;
    }
}
