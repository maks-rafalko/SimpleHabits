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
        $abstinence->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function findById(AbstinenceId $id)
    {
        if (!array_key_exists((string) $id, $this->abstinences)) {
            return;
        }

        /** @var Abstinence $abstinence */
        $abstinence = $this->abstinences[(string) $id];

        if ($abstinence->isDeleted()) {
            return;
        }

        return $abstinence;
    }
}
