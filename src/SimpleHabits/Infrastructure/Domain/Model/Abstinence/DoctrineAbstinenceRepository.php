<?php

declare(strict_types=1);

namespace SimpleHabits\Infrastructure\Domain\Model\Abstinence;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
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
     * @var EntityRepository
     */
    private $repository;

    /**
     * DoctrineAbstinenceRepository constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository('SimpleHabits:Abstinence\Abstinence');
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
    public function findById(AbstinenceId $id) : Abstinence
    {
        // TODO complete
    }

    /**
     * {@inheritdoc}
     */
    public function findByUserId($userId)
    {
        // TODO rewrite it when user-abstinence realtion is created
        return $this->repository->findBy([], ['startedAt' => 'ASC']);
    }
}
