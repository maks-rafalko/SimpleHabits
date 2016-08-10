<?php

namespace SimpleHabits\Application\Handler;

use SimpleHabits\Domain\Model\Abstinence\Exception\AbstinenceDoesNotExistException;
use SimpleHabits\Domain\Model\Abstinence\AbstinenceRepository;
use SimpleHabits\Application\Command\AddViolationCommand;

class AddViolationCommandHandler
{
    /**
     * @var AbstinenceRepository
     */
    private $abstinenceRepository;
    
    /**
     * CreateNewAbstinenceCommandHandler constructor.
     * @param AbstinenceRepository $abstinenceRepository
     */
    public function __construct(AbstinenceRepository $abstinenceRepository)
    {
        $this->abstinenceRepository = $abstinenceRepository;
    }

    /**
     * @param AddViolationCommand $command
     * @throws AbstinenceDoesNotExistException
     */
    public function handle(AddViolationCommand $command)
    {
        $abstinenceId = $command->getAbstinenceId();
        
        $abstinence = $this->abstinenceRepository->findById($abstinenceId);
        
        if (null === $abstinence) {
            throw AbstinenceDoesNotExistException::withId($abstinenceId);
        }
        
        $abstinence->violate($command->getReason(), $command->getViolationDate());
    }
}
