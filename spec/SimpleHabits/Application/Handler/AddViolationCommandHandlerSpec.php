<?php

namespace spec\SimpleHabits\Application\Handler;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SimpleHabits\Application\Command\AddViolationCommand;
use SimpleHabits\Domain\Model\Abstinence\Abstinence;
use SimpleHabits\Domain\Model\Abstinence\AbstinenceId;
use SimpleHabits\Domain\Model\Abstinence\AbstinenceRepository;
use SimpleHabits\Domain\Model\Abstinence\Exception\AbstinenceDoesNotExistException;

class AddViolationCommandHandlerSpec extends ObjectBehavior
{
    public function let(AbstinenceRepository $abstinenceRepository)
    {
        $this->beConstructedWith($abstinenceRepository);
    }

    public function it_should_add_violation(AbstinenceRepository $abstinenceRepository)
    {
        $abstinence = $this->createAbstinence();
        $abstinenceId = new AbstinenceId();

        $command = new AddViolationCommand($abstinenceId, 'Bad mood', new \DateTimeImmutable());

        $abstinenceRepository->findById(Argument::exact($abstinenceId))
            ->willReturn($abstinence)
            ->shouldBeCalled();

        $this->handle($command);

        if (count($abstinence->getViolations()) !== 1) {
            throw new \RuntimeException(
                sprintf('Expected violation count is 1, %d given.', count($abstinence->getViolations()))
            );
        }
    }

    public function it_should_throw_an_exception_when_abstinence_is_not_found(AbstinenceRepository $abstinenceRepository)
    {
        $abstinenceId = new AbstinenceId();

        $command = new AddViolationCommand($abstinenceId, 'Bad mood');

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
        return new Abstinence(new AbstinenceId(), 'Do not smoke');
    }
}
