<?php

namespace App\Repository;

use App\Entity\AttendanceGrid;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AttendanceGrid|null find($id, $lockMode = null, $lockVersion = null)
 * @method AttendanceGrid|null findOneBy(array $criteria, array $orderBy = null)
 * @method AttendanceGrid[]    findAll()
 * @method AttendanceGrid[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttendanceGridRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AttendanceGrid::class);
    }

    // /**
    //  * @return AttendanceGrid[] Returns an array of AttendanceGrid objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AttendanceGrid
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
