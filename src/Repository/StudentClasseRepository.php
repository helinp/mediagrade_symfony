<?php

namespace App\Repository;

use App\Entity\StudentClasse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StudentClasse|null find($id, $lockMode = null, $lockVersion = null)
 * @method StudentClasse|null findOneBy(array $criteria, array $orderBy = null)
 * @method StudentClasse[]    findAll()
 * @method StudentClasse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentClasseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StudentClasse::class);
    }


	 public function getAttendanceStatistics($school_year)
 	{
 		return $this->createQueryBuilder('s')
 		->select('u.firstName, u.lastName, c.name AS classe,
			COUNT(a.id) AS total,
			SUM(a.isAbsent) AS absent,
			SUM(a.isPresent) AS present,
			SUM(a.isLate) AS late,
			(SUM(a.isPresent) / COUNT(a.status)) * 100 AS percentage
		')
		->join('s.student', 'u')
		->leftJoin('u.attendances', 'a')
		->leftJoin('a.attendanceGrid', 'g')
		->leftJoin('s.classe', 'c')
 		->andWhere('s.schoolyear = :val')
		->setParameter('val', $school_year)
 		->andWhere('g.schoolYear = :val')
 		->setParameter('val', $school_year)
 		->groupBy('u.id')
		->orderBy('c.name', 'ASC')
		->AddOrderBy('u.lastName', 'ASC')
		->AddOrderBy('u.firstName', 'ASC')
 		->getQuery()
 		->getResult()
 		;
 	}

    // /**
    //  * @return StudentClasse[] Returns an array of StudentClasse objects
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
    public function findOneBySomeField($value): ?StudentClasse
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
