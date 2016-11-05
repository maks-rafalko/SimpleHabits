<?php

declare(strict_types=1);

namespace SimpleHabits\Application\Handler\Goal;

use SimpleHabits\Application\Command\Goal\RemoveGoalCommand;
use SimpleHabits\Domain\Model\Goal\Exception\GoalDoesNotExistException;
use SimpleHabits\Domain\Model\Goal\GoalRepository;

class RemoveGoalHandler
{
    /**
     * @var GoalRepository
     */
    private $goalRepository;

    /**
     * RemoveAbstinenceHandler constructor.
     *
     * @param GoalRepository $goalRepository
     */
    public function __construct(GoalRepository $goalRepository)
    {
        $this->goalRepository = $goalRepository;
    }

    /**
     * @param RemoveGoalCommand $command
     *
     * @throws GoalDoesNotExistException
     */
    public function handle(RemoveGoalCommand $command)
    {
        $goalId = $command->getGoalId();

        $goal = $this->goalRepository->findById($goalId);

        if (null === $goal) {
            throw GoalDoesNotExistException::withId($goalId);
        }

        $this->goalRepository->remove($goal);
    }
}
