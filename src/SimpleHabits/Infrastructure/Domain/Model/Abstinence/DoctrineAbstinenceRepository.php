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
        $this->repository = $this->em->getRepository('SimpleHabits:Domain\Model\Abstinence\Abstinence');
    }

    /**
     * {@inheritdoc}
     */
    public function add(Abstinence $abstinence)
    {
        $this->em->persist($abstinence);
    }

    /**
     * {@inheritdoc}
     */
    public function remove(Abstinence $abstinence)
    {
        $this->em->remove($abstinence);
    }

    /**
     * {@inheritdoc}
     */
    public function findById(AbstinenceId $id) : Abstinence
    {
        return $this->repository->find($id);
    }

    /**
     * @param $userId
     * @return Abstinence[]
     */
    public function findByUserId($userId)
    {
        $qb = $this->repository->createQueryBuilder('a');

        return $qb->select('a, v')
            ->where('a.userId = :userId')
            ->leftJoin('a.violations', 'v')
            ->orderBy('a.startedAt', 'ASC')
            ->getQuery()
            ->setParameter(':userId', $userId)
            ->getResult();
    }
}
