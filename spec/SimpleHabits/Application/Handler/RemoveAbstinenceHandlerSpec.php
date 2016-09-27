<?php

namespace spec\SimpleHabits\Application\Handler;

use Prophecy\Argument;
use PhpSpec\ObjectBehavior;
use SimpleHabits\Application\Command\RemoveAbstinenceCommand;
use SimpleHabits\Domain\Model\Abstinence\Abstinence;
use SimpleHabits\Domain\Model\Abstinence\AbstinenceId;
use SimpleHabits\Domain\Model\Abstinence\AbstinenceRepository;
use SimpleHabits\Domain\Model\Abstinence\Exception\AbstinenceDoesNotExistException;
use SimpleHabits\Domain\Model\User\UserId;

class RemoveAbstinenceHandlerSpec extends ObjectBehavior
{
    const NAME = 'Do not smoke';

    public function let(AbstinenceRepository $abstinenceRepository)
    {
        $this->beConstructedWith($abstinenceRepository);
    }

    public function it_should_remove_abstinence(AbstinenceRepository $abstinenceRepository)
    {
        $abstinence = $this->createAbstinence();
        $abstinenceId = new AbstinenceId();

        $command = new RemoveAbstinenceCommand($abstinenceId);

        $abstinenceRepository->findById(Argument::exact($abstinenceId))
            ->willReturn($abstinence)
            ->shouldBeCalled();

        $abstinenceRepository->remove(Argument::exact($abstinence))->shouldBeCalled();

        $this->handle($command);
    }

    public function it_should_throw_an_exception_when_abstinence_is_not_found(AbstinenceRepository $abstinenceRepository)
    {
        $abstinenceId = new AbstinenceId();
        $command = new RemoveAbstinenceCommand($abstinenceId, 'Bad mood');

        $abstinenceRepository->findById(Argument::exact($abstinenceId))
            ->willReturn(null)
            ->shouldBeCalled();

        $this->shouldThrow(AbstinenceDoesNotExistException::class)->during('handle', [$command]);
    }

    /**
     * @return Abstinence
     */
    private function createAbstinence()
    {
        return new Abstinence(new UserId(), new AbstinenceId(), self::NAME);
    }
}
