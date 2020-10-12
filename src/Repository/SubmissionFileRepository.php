<?php

namespace App\Repository;

use App\Entity\SubmissionFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SubmissionFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubmissionFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubmissionFile[]    findAll()
 * @method SubmissionFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubmissionFileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubmissionFile::class);
    }

    // /**
    //  * @return SubmissionFile[] Returns an array of SubmissionFile objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SubmissionFile
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
