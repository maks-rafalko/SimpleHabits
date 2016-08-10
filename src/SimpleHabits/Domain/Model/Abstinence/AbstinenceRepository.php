<?php

namespace SimpleHabits\Domain\Model\Abstinence;

interface AbstinenceRepository
{
    /**
     * @param Abstinence $abstinence
     */
    public function add(Abstinence $abstinence);

    /**
     * @param Abstinence $abstinence
     */
    public function remove(Abstinence $abstinence);

    /**
     * @param AbstinenceId $id
     * @return null|Abstinence
     */
    public function findById(AbstinenceId $id);
}
