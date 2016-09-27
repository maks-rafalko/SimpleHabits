<?php

namespace SimpleHabits\Application\Handler;

use SimpleHabits\Application\Command\CreateNewAbstinenceCommand;
use SimpleHabits\Domain\Model\Abstinence\Abstinence;
use SimpleHabits\Domain\Model\Abstinence\AbstinenceId;
use SimpleHabits\Domain\Model\Abstinence\AbstinenceRepository;
use SimpleHabits\Domain\Model\User\UserId;

class CreateNewAbstinenceHandler
{
    /**
     * @var AbstinenceRepository
     */
    private $abstinenceRepository;

    /**
     * CreateNewAbstinenceHandler constructor.
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
        $userId = $createNewAbstinenceCommand->getUserId();
        $name = $createNewAbstinenceCommand->getName();

        $abstinence = new Abstinence(new UserId($userId), new AbstinenceId(), $name);

        $this->abstinenceRepository->add($abstinence);
    }
}
