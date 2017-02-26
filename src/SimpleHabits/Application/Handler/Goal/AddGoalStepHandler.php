<?php

namespace SimpleHabits\Application\Handler\Goal;

use SimpleHabits\Application\Command\Goal\AddGoalStepCommand;
use SimpleHabits\Domain\Model\Goal\Exception\GoalDoesNotExistException;
use SimpleHabits\Domain\Model\Goal\GoalRepository;

class AddGoalStepHandler
{
    /**
     * @var GoalRepository
     */
    private $goalRepository;

    /**
     * AddGoalStepHandler constructor.
     *
     * @param GoalRepository $goalRepository
     */
    public function __construct(GoalRepository $goalRepository)
    {
        $this->goalRepository = $goalRepository;
    }

    /**
     * @param AddGoalStepCommand $command
     *
     * @throws GoalDoesNotExistException
     */
    public function handle(AddGoalStepCommand $command)
    {
        $goalId = $command->getGoalId();

        $goal = $this->goalRepository->findById($goalId);

        if (null === $goal) {
            throw GoalDoesNotExistException::withId($goalId);
        }

        $goal->addGoalStepWithValue($command->getValue(), $command->getDate());
    }
}
