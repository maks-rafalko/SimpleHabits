<?php

namespace spec\SimpleHabits\Infrastructure\Domain\Model\Goal;

use PhpSpec\ObjectBehavior;
use SimpleHabits\Domain\Model\Goal\Goal;
use SimpleHabits\Domain\Model\Goal\GoalId;
use SimpleHabits\Domain\Model\User\UserId;
use SimpleHabits\Infrastructure\Domain\Model\Goal\InMemoryGoalRepository;

class InMemoryGoalRepositorySpec extends ObjectBehavior
{
    const NAME = 'Loose weight';

    public function it_is_initializable()
    {
        $this->shouldHaveType(InMemoryGoalRepository::class);
    }

    public function it_should_add_goal()
    {
        $id = new GoalId();

        $this->add($this->generateGoal($id));

        $this->findById($id)->getName()->shouldReturn(self::NAME);
    }

    public function it_should_remove_existing_one()
    {
        $id = new GoalId();
        $goal = $this->generateGoal($id);

        $this->add($goal);

        $this->remove($goal);
        $this->findById($id)->shouldReturn(null);
    }

    public function it_should_find_by_user_id()
    {
        $userId = new UserId();

        $this->add($this->generateGoal(new GoalId(), $userId));
        $this->add($this->generateGoal(new GoalId(), $userId));
        $this->add($this->generateGoal(new GoalId(), new UserId()));

        $this->findByUserId($userId)->shouldHaveCount(2);
    }

    private function generateGoal($id, $userId = null)
    {
        return new Goal($userId ?: new UserId(), $id, self::NAME, new \DateTimeImmutable('+1 month'), 1, 2);
    }
}
