<?php

namespace SimpleHabits\Domain\Model\Violation;

use Ramsey\Uuid\Uuid;

class ViolationId
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
    public function id()
    {
        return $this->id;
    }

    /**
     * @param ViolationId $violationId
     *
     * @return bool
     */
    public function equals(ViolationId $violationId)
    {
        return $this->id() === $violationId->id();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id();
    }
}
