<?php

declare(strict_types=1);

namespace SimpleHabits\Infrastructure\Domain\Model\Goal;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use SimpleHabits\Domain\Model\Goal\Goal;
use SimpleHabits\Domain\Model\Goal\GoalId;
use SimpleHabits\Domain\Model\Goal\GoalRepository;

class DoctrineGoalRepository implements GoalRepository
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
     * DoctrineGoalRepository constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository('SimpleHabits:Domain\Model\Goal\Goal');
    }

    /**
     * {@inheritdoc}
     */
    public function add(Goal $goal)
    {
        $this->em->persist($goal);
    }

    /**
     * {@inheritdoc}
     */
    public function remove(Goal $goal)
    {
        $this->em->remove($goal);
    }

    /**
     * {@inheritdoc}
     */
    public function findById(GoalId $id) : Goal
    {
        return $this->repository->find($id);
    }

    /**
     * @param $userId
     * @return Goal[]
     */
    public function findByUserId($userId)
    {
        $qb = $this->repository->createQueryBuilder('g');

        return $qb->select('g, gs')
            ->where('g.userId = :userId')
            ->leftJoin('g.goalSteps', 'gs')
            ->orderBy('g.startedAt', 'ASC')
            ->getQuery()
            ->setParameter(':userId', $userId)
            ->getResult();
    }
}
