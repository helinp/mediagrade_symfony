<?php

namespace App\Repository;

use App\Entity\SelfAssessmentAnswer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SelfAssessmentAnswer|null find($id, $lockMode = null, $lockVersion = null)
 * @method SelfAssessmentAnswer|null findOneBy(array $criteria, array $orderBy = null)
 * @method SelfAssessmentAnswer[]    findAll()
 * @method SelfAssessmentAnswer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SelfAssessmentAnswerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SelfAssessmentAnswer::class);
    }

    // /**
    //  * @return SelfAssessmentAnswer[] Returns an array of SelfAssessmentAnswer objects
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
    public function findOneBySomeField($value): ?SelfAssessmentAnswer
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
