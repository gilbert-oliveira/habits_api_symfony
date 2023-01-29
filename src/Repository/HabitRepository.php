<?php

namespace App\Repository;

use App\Entity\Habit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Habit>
 *
 * @method Habit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Habit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Habit[]    findAll()
 * @method Habit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HabitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Habit::class);
    }

    public function save(Habit $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Habit $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByDay(\DateTimeImmutable $date): array
    {
        return $this->createQueryBuilder('h')
            ->innerJoin('h.days', 'd')
            ->andWhere("d.date LIKE :date")
            ->setParameter('date', $date->format('Y-m-d') . '%')
            ->getQuery()
            ->getResult()
        ;
    }
}
