<?php

declare(strict_types=1);

namespace SimpleHabits\Application\Command;


use SimpleHabits\Domain\Model\Abstinence\AbstinenceId;

class UpdateAbstinenceCommand
{
    /**
     * @var AbstinenceId
     */
    private $abstinenceId;
    
    /**
     * @var null|string
     */
    private $name;

    /**
     * @var \DateTimeInterface|null
     */
    private $startedAt;

    /**
     * UpdateAbstinenceCommand constructor.
     * 
     * @param AbstinenceId $abstinenceId
     * @param string|null $name
     * @param \DateTimeInterface|null $startedAt
     */
    public function __construct(AbstinenceId $abstinenceId, string $name = null, \DateTimeInterface $startedAt = null)
    {
        $this->abstinenceId = $abstinenceId;
        $this->name = $name;
        $this->startedAt = $startedAt;
    }

    /**
     * @return AbstinenceId
     */
    public function getAbstinenceId()
    {
        return $this->abstinenceId;
    }
    
    /**
     * @return null|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getStartedAt()
    {
        return $this->startedAt;
    }
}