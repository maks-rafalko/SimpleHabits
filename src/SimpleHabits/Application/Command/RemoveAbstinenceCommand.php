<?php

declare(strict_types=1);

namespace SimpleHabits\Application\Command;

use SimpleHabits\Domain\Model\Abstinence\AbstinenceId;

class RemoveAbstinenceCommand
{
    /**
     * @var AbstinenceId
     */
    private $abstinenceId;

    /**
     * @param AbstinenceId $abstinenceId
     */
    public function __construct(AbstinenceId $abstinenceId)
    {
        $this->abstinenceId = $abstinenceId;
    }

    /**
     * @return AbstinenceId
     */
    public function getAbstinenceId()
    {
        return $this->abstinenceId;
    }
}
