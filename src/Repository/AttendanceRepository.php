<?php

namespace App\Repository;

use App\Entity\Attendance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Attendance|null find($id, $lockMode = null, $lockVersion = null)
 * @method Attendance|null findOneBy(array $criteria, array $orderBy = null)
 * @method Attendance[]    findAll()
 * @method Attendance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttendanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Attendance::class);
    }


    public function getAttendanceStatistics($school_year, $student)
    {
        return $this->createQueryBuilder('a')
        ->select('
           COUNT(a.id) AS total,
           SUM(a.isAbsent) AS absent,
           SUM(a.isPresent) AS present,
           SUM(a.isLate) AS late,
           (SUM(a.isPresent) / COUNT(a.status)) * 100 AS percentage
       ')
       ->join('a.attendanceGrid', 'ag')
  
        ->andWhere('ag.schoolYear = :val')
       ->setParameter('val', $school_year)
        ->andWhere('a.student = :val1')
        ->setParameter('val1', $student)
        ->groupBy('a.student')
        ->getQuery()
        ->getOneOrNullResult()
        ;
    }


    public function getStudentAttendance($student, $school_year)
    {
        return $this->createQueryBuilder('a')
        ->select('a.status AS status, ag.date AS date')
       ->join('a.attendanceGrid', 'ag')
  
        ->andWhere('ag.schoolYear = :val')
         ->setParameter('val', $school_year)
        ->andWhere('a.student = :val1')
        ->setParameter('val1', $student)
        ->getQuery()
        ->getResult()
        ;
    }

    // /**
    //  * @return Attendance[] Returns an array of Attendance objects
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
    public function findOneBySomeField($value): ?Attendance
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
