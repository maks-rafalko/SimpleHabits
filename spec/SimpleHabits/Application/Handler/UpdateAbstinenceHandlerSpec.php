<?php

namespace spec\SimpleHabits\Application\Handler;

use Prophecy\Argument;
use PhpSpec\ObjectBehavior;
use SimpleHabits\Application\Command\UpdateAbstinenceCommand;
use SimpleHabits\Domain\Model\Abstinence\Abstinence;
use SimpleHabits\Domain\Model\Abstinence\AbstinenceId;
use SimpleHabits\Domain\Model\Abstinence\AbstinenceRepository;

class UpdateAbstinenceHandlerSpec extends ObjectBehavior
{
    const NAME = 'Do not smoke';
    const NEW_NAME = 'Do not drink';

    public function let(AbstinenceRepository $abstinenceRepository)
    {
        $this->beConstructedWith($abstinenceRepository);
    }

    public function it_should_change_name(AbstinenceRepository $abstinenceRepository)
    {
        $abstinence = $this->createAbstinence();
        $abstinenceId = new AbstinenceId();

        $command = new UpdateAbstinenceCommand($abstinenceId, self::NEW_NAME);

        $abstinenceRepository->findById(Argument::exact($abstinenceId))
            ->willReturn($abstinence)
            ->shouldBeCalled();

        $this->handle($command);

        if ($abstinence->getName() !== self::NEW_NAME) {
            throw new \RuntimeException('Abstinence name is not changed');
        }
    }

    public function it_should_change_start_date(AbstinenceRepository $abstinenceRepository)
    {
        $abstinence = $this->createAbstinence();
        $abstinenceId = new AbstinenceId();

        $newStartDate = new \DateTimeImmutable('-2 days');
        $command = new UpdateAbstinenceCommand($abstinenceId, null, $newStartDate);

        $abstinenceRepository->findById(Argument::exact($abstinenceId))
            ->willReturn($abstinence)
            ->shouldBeCalled();

        $this->handle($command);

        if ($abstinence->getStartedAt() != $newStartDate) {
            throw new \RuntimeException('Abstinence startDate is not changed');
        }
    }

    /**
     * @return Abstinence
     */
    private function createAbstinence()
    {
        return new Abstinence(new AbstinenceId(), self::NAME);
    }
}
