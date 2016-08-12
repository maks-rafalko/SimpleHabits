<?php

declare(strict_types=1);

namespace SimpleHabits\Application\Handler;

use SimpleHabits\Application\Command\RemoveAbstinenceCommand;
use SimpleHabits\Domain\Model\Abstinence\AbstinenceRepository;
use SimpleHabits\Domain\Model\Abstinence\Exception\AbstinenceDoesNotExistException;

class RemoveAbstinenceHandler
{
    /**
     * @var AbstinenceRepository
     */
    private $abstinenceRepository;

    /**
     * RemoveAbstinenceHandler constructor.
     *
     * @param AbstinenceRepository $abstinenceRepository
     */
    public function __construct(AbstinenceRepository $abstinenceRepository)
    {
        $this->abstinenceRepository = $abstinenceRepository;
    }

    /**
     * @param RemoveAbstinenceCommand $command
     *
     * @throws AbstinenceDoesNotExistException
     */
    public function handle(RemoveAbstinenceCommand $command)
    {
        $abstinenceId = $command->getAbstinenceId();

        $abstinence = $this->abstinenceRepository->findById($abstinenceId);

        if (null === $abstinence) {
            throw AbstinenceDoesNotExistException::withId($abstinenceId);
        }

        $this->abstinenceRepository->remove($abstinence);
    }
}
