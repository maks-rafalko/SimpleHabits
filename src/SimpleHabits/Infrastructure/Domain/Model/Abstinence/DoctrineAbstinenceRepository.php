<?php

namespace SimpleHabits\Infrastructure\Domain\Model\Abstinence;

use Doctrine\ORM\EntityManagerInterface;
use SimpleHabits\Domain\Model\Abstinence\Abstinence;
use SimpleHabits\Domain\Model\Abstinence\AbstinenceId;
use SimpleHabits\Domain\Model\Abstinence\AbstinenceRepository;

class DoctrineAbstinenceRepository implements AbstinenceRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * DoctrineAbstinenceRepository constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function add(Abstinence $abstinence)
    {
        // TODO check whether we should write a spec for it or no

        $this->em->persist($abstinence);
    }

    /**
     * {@inheritdoc}
     */
    public function remove(Abstinence $abstinence)
    {
        // TODO complete
    }

    /**
     * {@inheritdoc}
     */
    public function findById(AbstinenceId $id)
    {
        // TODO complete
    }
}
