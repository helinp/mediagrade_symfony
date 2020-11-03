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
    
    public function findAllGallery()
    {
        return $this->createQueryBuilder('s')
            ->join('s.submission', 'sub')
            ->join('sub.project', 'p')
            ->join('sub.student', 'st')
            ->andWhere('s.public = TRUE')
            ->orderBy('p.schoolYear', 'DESC')
            ->addOrderBy('p.startDate', 'DESC')
            ->addOrderBy('st.lastName', 'ASC')
            ->addOrderBy('st.firstName', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }   

    public function findAllGalleryByStudent($student)
    {
        return $this->createQueryBuilder('s')
            ->join('s.submission', 'sub')
            ->join('sub.project', 'p')
            ->join('sub.student', 'st')
            ->andWhere('sub.student = :val')
            ->setParameter('val', $student)
            ->orderBy('p.schoolYear', 'DESC')
            ->addOrderBy('p.startDate', 'DESC')
            ->addOrderBy('st.lastName', 'ASC')
            ->addOrderBy('st.firstName', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    

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
