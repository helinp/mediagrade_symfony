<?php

namespace App\Repository;

use App\Entity\GradingSystem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GradingSystem|null find($id, $lockMode = null, $lockVersion = null)
 * @method GradingSystem|null findOneBy(array $criteria, array $orderBy = null)
 * @method GradingSystem[]    findAll()
 * @method GradingSystem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GradingSystemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GradingSystem::class);
    }

    // /**
    //  * @return GradingSystem[] Returns an array of GradingSystem objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GradingSystem
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
