<?php

namespace spec\SimpleHabits\Infrastructure\Domain\Model\Abstinence;

use PhpSpec\ObjectBehavior;
use SimpleHabits\Domain\Model\Abstinence\Abstinence;
use SimpleHabits\Domain\Model\Abstinence\AbstinenceId;
use SimpleHabits\Domain\Model\User\UserId;
use SimpleHabits\Infrastructure\Domain\Model\Abstinence\InMemoryAbstinenceRepository;

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
        $this->add(new Abstinence(new UserId(), $id, self::NAME));

        $this->findById($id)->getName()->shouldReturn(self::NAME);
    }

    public function it_should_remove_existing_one()
    {
        $id = new AbstinenceId();
        $abstinence = new Abstinence(new UserId(), $id, self::NAME);

        $this->add($abstinence);

        $this->remove($abstinence);
        $this->findById($id)->shouldReturn(null);
    }

    public function it_should_find_by_user_iid()
    {
        $userId = new UserId();

        $this->add(new Abstinence($userId, new AbstinenceId(), self::NAME));
        $this->add(new Abstinence($userId, new AbstinenceId(), self::NAME.' 2'));
        $this->add(new Abstinence(new UserId(), new AbstinenceId(), self::NAME.' 3'));

        $this->findByUserId($userId)->shouldHaveCount(2);
    }
}
