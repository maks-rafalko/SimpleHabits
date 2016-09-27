<?php

namespace SimpleHabits\Domain\Model\User;

use Ramsey\Uuid\Uuid;

class UserId
{
    /**
     * @var string
     */
    private $id;

    /**
     * @param string $id
     */
    public function __construct(string $id = null)
    {
        $this->id = null === $id ? Uuid::uuid4()->toString() : $id;
    }

    /**
     * @return string
     */
    public function id() : string
    {
        return $this->id;
    }

    /**
     * @param UserId $userId
     *
     * @return bool
     */
    public function equals(UserId $userId) : bool
    {
        return $this->id() === $userId->id();
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return $this->id();
    }
}
