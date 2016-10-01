<?php

namespace SimpleHabits\Infrastructure\Domain\Model\User;

use SimpleHabits\Domain\Model\User\User as BaseUser;
use Symfony\Component\Security\Core\User\UserInterface;

class User extends BaseUser implements UserInterface
{
    /**
     * @return array
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getSalt()
    {
        return null;
    }

    /**
     * Erase credentials.
     */
    public function eraseCredentials()
    {
    }
}
