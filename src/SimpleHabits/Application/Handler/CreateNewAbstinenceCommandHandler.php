<?php

namespace SimpleHabits\Application\Handler;

use SimpleHabits\Application\Command\CreateNewAbstinenceCommand;
use SimpleHabits\Domain\Model\Abstinence\Abstinence;
use SimpleHabits\Domain\Model\Abstinence\AbstinenceId;
use SimpleHabits\Domain\Model\Abstinence\AbstinenceRepository;

class CreateNewAbstinenceCommandHandler
{
    /**
     * @var AbstinenceRepository
     */
    private $abstinenceRepository;

    /**
     * CreateNewAbstinenceCommandHandler constructor.
     *
     * @param AbstinenceRepository $abstinenceRepository
     */
    public function __construct(AbstinenceRepository $abstinenceRepository)
    {
        $this->abstinenceRepository = $abstinenceRepository;
    }

    /**
     * @param CreateNewAbstinenceCommand $createNewAbstinenceCommand
     */
    public function handle(CreateNewAbstinenceCommand $createNewAbstinenceCommand)
    {
        $name = $createNewAbstinenceCommand->getName();

        $abstinence = new Abstinence(new AbstinenceId(), $name);

        $this->abstinenceRepository->add($abstinence);
    }
}
