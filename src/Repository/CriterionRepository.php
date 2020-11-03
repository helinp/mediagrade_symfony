<?php

namespace App\Repository;

use App\Entity\Criterion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Criterion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Criterion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Criterion[]    findAll()
 * @method Criterion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CriterionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Criterion::class);
    }

    // /**
    //  * @return Criterion[] Returns an array of Criterion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Criterion
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAllMatching(string $query, int $limit = 5)
    {
        return $this->createQueryBuilder('c')
            ->select('c.name')
            ->distinct('c.name')
            ->orderBy('c.name', 'ASC')
            ->andWhere('c.name like :val')
            ->setParameter('val', '%' . $query . '%')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
