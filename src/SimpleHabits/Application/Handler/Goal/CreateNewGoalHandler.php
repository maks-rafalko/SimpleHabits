<?php

namespace SimpleHabits\Application\Handler\Goal;

use SimpleHabits\Domain\Model\Goal\Goal;
use SimpleHabits\Domain\Model\Goal\GoalId;
use SimpleHabits\Domain\Model\Goal\GoalRepository;
use SimpleHabits\Application\Command\Goal\CreateNewGoalCommand;
use SimpleHabits\Domain\Model\User\UserId;

class CreateNewGoalHandler
{
    /**
     * @var GoalRepository
     */
    private $goalRepository;

    /**
     * CreateNewGoalHandler constructor.
     * @param GoalRepository $goalRepository
     */
    public function __construct(GoalRepository $goalRepository)
    {
        $this->goalRepository = $goalRepository;
    }

    /**
     * @param CreateNewGoalCommand $createNewGoalCommand
     */
    public function handle(CreateNewGoalCommand $createNewGoalCommand)
    {
        $userId = $createNewGoalCommand->getUserId();
        $name = $createNewGoalCommand->getName();
        $targetDate = $createNewGoalCommand->getTargetDate();
        $targetValue = $createNewGoalCommand->getTargetValue();
        $initialValue = $createNewGoalCommand->getInitialValue();

        $abstinence = new Goal(new GoalId(), $name, $targetDate, $targetValue, $initialValue);

        $this->goalRepository->add($abstinence);
    }
}
