<?php

namespace SimpleHabits\Infrastructure\Domain\Model\Goal;

use SimpleHabits\Domain\Model\Goal\Goal;
use SimpleHabits\Domain\Model\Goal\GoalId;
use SimpleHabits\Domain\Model\Goal\GoalRepository;
use SimpleHabits\Domain\Model\User\UserId;

class InMemoryGoalRepository implements GoalRepository
{
    /**
     * @var array
     */
    private $goals = [];

    /**
     * {@inheritdoc}
     */
    public function add(Goal $goal)
    {
        $this->goals[(string) $goal->getId()] = $goal;
    }

    /**
     * {@inheritdoc}
     */
    public function remove(Goal $goal)
    {
        $goal->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function findById(GoalId $id)
    {
        if (!array_key_exists((string) $id, $this->goals)) {
            return null;
        }

        /** @var Goal $abstinence */
        $abstinence = $this->goals[(string) $id];

        if ($abstinence->isDeleted()) {
            return null;
        }

        return $abstinence;
    }

    /**
     * {@inheritdoc}
     */
    public function findByUserId($userId)
    {
        $userIdObject = is_string($userId) ? new UserId($userId) : $userId;

        return array_filter(
            $this->goals,
            function (Goal $goal) use ($userIdObject) {
                return $goal->getUserId()->equals($userIdObject);
            }
        );
    }
}
