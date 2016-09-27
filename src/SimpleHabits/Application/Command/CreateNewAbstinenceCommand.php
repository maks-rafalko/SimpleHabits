<?php

declare(strict_types=1);

namespace SimpleHabits\Application\Command;

use SimpleHabits\Domain\Model\User\UserId;

class CreateNewAbstinenceCommand
{
    /**
     * @var UserId
     */
    private $userId;

    /**
     * @var string
     */
    private $name;

    /**
     * @param UserId $userId
     * @param string $name
     */
    public function __construct(UserId $userId, string $name)
    {
        $this->userId = $userId;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @return UserId
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
