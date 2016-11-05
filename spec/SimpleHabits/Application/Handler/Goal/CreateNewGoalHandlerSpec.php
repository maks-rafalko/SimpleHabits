<?php

namespace spec\SimpleHabits\Application\Handler\Goal;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SimpleHabits\Application\Command\Goal\CreateNewGoalCommand;
use SimpleHabits\Domain\Model\Goal\Goal;
use SimpleHabits\Domain\Model\Goal\GoalRepository;
use SimpleHabits\Domain\Model\User\UserId;

class CreateNewGoalHandlerSpec extends ObjectBehavior
{
    const NAME = 'Loos weight';

    public function let(GoalRepository $goalRepository)
    {
        $this->beConstructedWith($goalRepository);
    }

    public function it_should_add_new_goal_to_repository(GoalRepository $goalRepository)
    {
        $command = new CreateNewGoalCommand(new UserId(), self::NAME, new \DateTimeImmutable('+1 month'), 1, 2);

        $goalRepository->add(Argument::type(Goal::class))->shouldBeCalled();

        $this->handle($command);
    }
}
