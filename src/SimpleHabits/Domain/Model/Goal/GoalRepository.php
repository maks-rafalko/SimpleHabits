<?php

namespace SimpleHabits\Domain\Model\Goal;

interface GoalRepository
{
    /**
     * @param Goal $goal
     */
    public function add(Goal $goal);

    /**
     * @param Goal $goal
     */
    public function remove(Goal $goal);

    /**
     * @param GoalId $id
     *
     * @return null|Goal
     */
    public function findById(GoalId $id);

    /**
     * @param $userId
     */
    public function findByUserId($userId);
}
