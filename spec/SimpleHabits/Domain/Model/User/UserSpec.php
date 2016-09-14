<?php

namespace spec\SimpleHabits\Domain\Model\User;

use SimpleHabits\Domain\Model\User\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SimpleHabits\Domain\Model\User\UserId;

class UserSpec extends ObjectBehavior
{
    const EMAIL = 'test@test.com';
    const PASSWORD = '12345678';

    public function let()
    {
        $this->beConstructedWith(new UserId(), self::EMAIL, self::PASSWORD);
    }

    public function it_should_have_an_id()
    {
        $this->getId()->shouldReturnAnInstanceOf(UserId::class);
    }

    public function it_has_an_email()
    {
        $this->getEmail()->shouldEqual(self::EMAIL);
    }

    public function it_has_a_password()
    {
        $this->getPassword()->shouldEqual(self::PASSWORD);
    }

    public function it_should_change_password()
    {
        $this->getPassword()->shouldEqual(self::PASSWORD);
        $this->changePassword('a');
        $this->getPassword()->shouldEqual('a');
    }
}
