<?php

namespace SimpleHabits\Domain\Model\Violation;

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
     * Violation constructor.
     *
     * @param ViolationId             $id
     * @param null|string             $reason
     * @param null|\DateTimeInterface $violatedAt
     */
    public function __construct(ViolationId $id, $reason = null, $violatedAt = null)
    {
        $now = new \DateTimeImmutable();
        \Assert\that($reason)->nullOr()->string()->maxLength(self::MAX_REASON_LENGTH);
        \Assert\that($violatedAt)->nullOr()->lessOrEqualThan($now);

        $this->id = $id;
        $this->reason = $reason;
        $this->violatedAt = $violatedAt ?: $now;
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
