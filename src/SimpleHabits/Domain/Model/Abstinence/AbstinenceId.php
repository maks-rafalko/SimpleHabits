<?php

declare(strict_types=1);

namespace SimpleHabits\Domain\Model\Abstinence;

use Ramsey\Uuid\Uuid;

class AbstinenceId
{
    /**
     * @var string
     */
    private $id;

    /**
     * @param string $id
     */
    public function __construct($id = null)
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
     * @param AbstinenceId $abstinenceId
     *
     * @return bool
     */
    public function equals(AbstinenceId $abstinenceId) : bool
    {
        return $this->id() === $abstinenceId->id();
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return $this->id();
    }
}
