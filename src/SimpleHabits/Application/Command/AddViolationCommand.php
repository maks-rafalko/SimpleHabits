<?php
declare(strict_types = 1);

namespace SimpleHabits\Application\Command;

use SimpleHabits\Domain\Model\Abstinence\AbstinenceId;

class AddViolationCommand
{
    /**
     * @var AbstinenceId
     */
    private $abstinenceId;

    /**
     * @var string
     */
    private $reason;

    /**
     * @var
     */
    private $violationDate;

    /**
     * AddViolationCommand constructor.
     * @param AbstinenceId $abstinenceId
     * @param string|null $reason
     * @param \DateTimeInterface|null $violationDate
     */
    public function __construct(AbstinenceId $abstinenceId, string $reason = null, \DateTimeInterface $violationDate = null)
    {
        $this->abstinenceId = $abstinenceId;
        $this->reason = $reason;
        $this->violationDate = $violationDate;
    }

    /**
     * @return AbstinenceId
     */
    public function getAbstinenceId() : AbstinenceId
    {
        return $this->abstinenceId;
    }

    /**
     * @return string
     */
    public function getReason() : string
    {
        return $this->reason;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getViolationDate() : \DateTimeInterface
    {
        return $this->violationDate;
    }
}