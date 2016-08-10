<?php

namespace SimpleHabits\Infrastructure\Domain\Model\Abstinence;

use SimpleHabits\Domain\Model\Abstinence\Abstinence;
use SimpleHabits\Domain\Model\Abstinence\AbstinenceId;
use SimpleHabits\Domain\Model\Abstinence\AbstinenceRepository;

class InMemoryAbstinenceRepository implements AbstinenceRepository
{
    /**
     * @var array
     */
    private $abstinences = [];

    /**
     * {@inheritdoc}
     */
    public function add(Abstinence $abstinence)
    {
        $this->abstinences[(string) $abstinence->getId()] = $abstinence;
    }

    /**
     * {@inheritdoc}
     */
    public function remove(Abstinence $abstinence)
    {
        unset($this->abstinences[(string) $abstinence->getId()]);
    }

    /**
     * {@inheritdoc}
     */
    public function findById(AbstinenceId $id)
    {
        return $this->abstinences[(string) $id] ?? null;
    }
}
