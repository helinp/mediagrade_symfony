<?php

namespace App\Repository;

use App\Entity\Project;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    // /**
    //  * @return Project[] Returns an array of Project objects
    //  */

    public function findByCourses($courses)
    {

        return $this->createQueryBuilder('p')->in('course', $courses)->getQuery()->getResult();
    }

    public function getCurrentProjects($teacher, $school_year)
    {
        $objDateTime = new DateTime('NOW');

        return $this->createQueryBuilder('p')
            ->join('p.course', 'c')

            ->andWhere('p.teacher = :val1')
            ->setParameter('val1', $teacher)

            ->andWhere('p.schoolYear = :val2')
            ->setParameter('val2', $school_year)

            ->andWhere('p.hardDeadline >= :val3')
            ->setParameter('val3', $objDateTime)

            ->addOrderBy('c.name', 'ASC')
            ->addOrderBy('p.hardDeadline', 'DESC')

            ->getQuery()
            ->getResult();
    }


    public function findByClasseAndSchoolyear($classe, $school_year)
    {
        return $this->createQueryBuilder('p')
            ->join('p.course', 'c')
            ->andWhere('c.classe = :val1')
            ->setParameter('val1', $classe)
            ->andWhere('p.schoolYear = :val2')
            ->setParameter('val2', $school_year)
            ->addOrderBy('p.term', 'DESC')
            //->addOrderBy('p.course', 'ASC')
            ->addOrderBy('p.startDate', 'DESC')
            ->getQuery()
            ->getResult();
    }
    /*
    public function findOneBySomeField($value): ?Project
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
