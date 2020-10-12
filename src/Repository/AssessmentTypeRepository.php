<?php

namespace App\Repository;

use App\Entity\AssessmentType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AssessmentType|null find($id, $lockMode = null, $lockVersion = null)
 * @method AssessmentType|null findOneBy(array $criteria, array $orderBy = null)
 * @method AssessmentType[]    findAll()
 * @method AssessmentType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssessmentTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AssessmentType::class);
    }

    // /**
    //  * @return AssessmentType[] Returns an array of AssessmentType objects
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
    public function findOneBySomeField($value): ?AssessmentType
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
