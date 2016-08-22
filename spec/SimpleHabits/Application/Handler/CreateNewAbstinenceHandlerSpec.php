<?php

namespace spec\SimpleHabits\Application\Handler;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SimpleHabits\Application\Command\CreateNewAbstinenceCommand;
use SimpleHabits\Domain\Model\Abstinence\Abstinence;
use SimpleHabits\Domain\Model\Abstinence\AbstinenceRepository;

class CreateNewAbstinenceHandlerSpec extends ObjectBehavior
{
    const NAME = 'Do not smoke';

    public function let(AbstinenceRepository $abstinenceRepository)
    {
        $this->beConstructedWith($abstinenceRepository);
    }

    public function it_should_add_new_abstinence_to_repository(AbstinenceRepository $abstinenceRepository)
    {
        $command = new CreateNewAbstinenceCommand(self::NAME);

        $abstinenceRepository->add(
            Argument::type(Abstinence::class)
        )->shouldBeCalled();

        $this->handle($command);
    }
}
