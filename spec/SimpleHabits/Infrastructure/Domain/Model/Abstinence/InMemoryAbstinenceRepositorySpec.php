<?php

namespace spec\SimpleHabits\Infrastructure\Domain\Model\Abstinence;

use SimpleHabits\Domain\Model\Abstinence\Abstinence;
use SimpleHabits\Domain\Model\Abstinence\AbstinenceId;
use SimpleHabits\Infrastructure\Domain\Model\Abstinence\InMemoryAbstinenceRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InMemoryAbstinenceRepositorySpec extends ObjectBehavior
{
    const NAME = 'Do not smoke';

    public function it_is_initializable()
    {
        $this->shouldHaveType(InMemoryAbstinenceRepository::class);
    }

    public function it_should_add_abstinence()
    {
        $id = new AbstinenceId();
        $this->add(new Abstinence($id, self::NAME));

        $this->findById($id)->getName()->shouldReturn(self::NAME);
    }

    public function it_should_remove_existing_one()
    {
        $id = new AbstinenceId();
        $abstinence = new Abstinence($id, self::NAME);

        $this->add($abstinence);

        $this->remove($abstinence);
        $this->findById($id)->shouldReturn(null);
    }
}
