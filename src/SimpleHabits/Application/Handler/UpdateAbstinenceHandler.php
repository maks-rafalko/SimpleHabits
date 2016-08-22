<?php

declare(strict_types=1);

namespace SimpleHabits\Application\Handler;

use SimpleHabits\Domain\Model\Abstinence\AbstinenceRepository;
use SimpleHabits\Application\Command\UpdateAbstinenceCommand;
use SimpleHabits\Domain\Model\Abstinence\Exception\AbstinenceDoesNotExistException;

class UpdateAbstinenceHandler
{
    /**
     * @var AbstinenceRepository
     */
    private $abstinenceRepository;

    /**
     * UpdateAbstinenceHandler constructor.
     *
     * @param AbstinenceRepository $abstinenceRepository
     */
    public function __construct(AbstinenceRepository $abstinenceRepository)
    {
        $this->abstinenceRepository = $abstinenceRepository;
    }

    /**
     * @param UpdateAbstinenceCommand $command
     *
     * @throws AbstinenceDoesNotExistException
     */
    public function handle(UpdateAbstinenceCommand $command)
    {
        $abstinenceId = $command->getAbstinenceId();

        $abstinence = $this->abstinenceRepository->findById($abstinenceId);

        if (null === $abstinence) {
            throw AbstinenceDoesNotExistException::withId($abstinenceId);
        }

        if ($command->getName() !== null) {
            $abstinence->changeName($command->getName());
        }

        if ($command->getStartedAt() !== null) {
            $abstinence->changeStartDate($command->getStartedAt());
        }
    }
}
