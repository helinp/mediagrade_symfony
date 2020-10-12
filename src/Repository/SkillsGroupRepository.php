<?php

namespace App\Repository;

use App\Entity\SkillsGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SkillsGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method SkillsGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method SkillsGroup[]    findAll()
 * @method SkillsGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkillsGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SkillsGroup::class);
    }

    // /**
    //  * @return SkillsGroup[] Returns an array of SkillsGroup objects
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
    public function findOneBySomeField($value): ?SkillsGroup
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
