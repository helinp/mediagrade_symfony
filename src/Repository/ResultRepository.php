<?php

namespace App\Repository;

use App\Entity\Result;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
* @method Result|null find($id, $lockMode = null, $lockVersion = null)
* @method Result|null findOneBy(array $criteria, array $orderBy = null)
* @method Result[]    findAll()
* @method Result[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
*/
class ResultRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, Result::class);
	}

	// /**
	//  * @return Result[] Returns an array of Result objects
	//  */
	/*
	public function findByExampleField($value)
	{
	return $this->createQueryBuilder('r')
	->andWhere('r.exampleField = :val')
	->setParameter('val', $value)
	->orderBy('r.id', 'ASC')
	->setMaxResults(10)
	->getQuery()
	->getResult()
	;
}
*/

/*
public function findOneBySomeField($value): ?Result
{
return $this->createQueryBuilder('r')
->andWhere('r.exampleField = :val')
->setParameter('val', $value)
->getQuery()
->getOneOrNullResult()
;
}
*/

public function getStudentResultByTerms($student, $shoolyear)
{
	return $this->createQueryBuilder('r')

	->select('SUM(r.userVote) / SUM(r.maxVote) * 100 AS percentage, t.name, t.description')
	->leftjoin('r.assessment', 'a')
	->leftjoin('a.project', 'p')
	->leftJoin('p.term', 't')
	->andWhere('r.student = :val')
	->andWhere('r.userVote IS NOT NULL')
	->setParameter('val', $student)
	->andWhere('p.schoolYear = :val1')
	->setParameter('val1', $shoolyear)
	->groupBy('t.id')
	->getQuery()
	->getResult();
	;
}

/**
 *  Used by teacher gradebook
 */
public function getStudentResultByCourseAndTerm($course, $student, $shoolyear, $term_id)
{
	return $this->createQueryBuilder('r')

	->select('SUM(r.userVote) / SUM(r.maxVote) * 100 AS percentage, t.name, t.description')
	->leftjoin('r.assessment', 'a')
	->leftjoin('a.project', 'p')
	->leftJoin('p.term', 't')
	->andWhere('p.course = :valc')
	->setParameter('valc', $course)
	->andWhere('r.student = :val')
	->setParameter('val', $student)
	->andWhere('p.schoolYear = :val1')
	->setParameter('val1', $shoolyear)
	->andWhere('r.userVote IS NOT NULL')
	->andWhere('t.id = :val2')
	->setParameter('val2', $term_id)
	->groupBy('t.id')
	->getQuery()
	->getOneOrNullResult()
	;
}

public function getStudentResultByTerm($student, $shoolyear, $term_id)
{
	return $this->createQueryBuilder('r')

	->select('SUM(r.userVote) / SUM(r.maxVote) * 100 AS percentage, t.name, t.description')
	->leftjoin('r.assessment', 'a')
	->leftjoin('a.project', 'p')
	->leftJoin('p.term', 't')
	->andWhere('r.student = :val')
	->setParameter('val', $student)
	->andWhere('p.schoolYear = :val1')
	->andWhere('r.userVote IS NOT NULL')
	->setParameter('val1', $shoolyear)
	->andWhere('t.id = :val2')
	->setParameter('val2', $term_id)
	->groupBy('t.id')
	->getQuery()
	->getOneOrNullResult()
	;
}

public function getStudentResultBySchoolyear($student, $shoolyear)
{
	return $this->createQueryBuilder('r')

	->select('SUM(r.userVote) / SUM(r.maxVote) * 100 AS percentage')
	->leftjoin('r.assessment', 'a')
	->leftjoin('a.project', 'p')
	->andWhere('r.student = :val')
	->setParameter('val', $student)
	->andWhere('p.schoolYear = :val1')
	->setParameter('val1', $shoolyear)
	->andWhere('r.userVote IS NOT NULL')
	->groupBy('p.schoolYear')
	->getQuery()
	->getOneOrNullResult()
	;
}

/**
 *  Used by Teacher gradebook
 */
public function getStudentResultByCourseAndSchoolyear($course, $student, $shoolyear)
{
	return $this->createQueryBuilder('r')

	->select('SUM(r.userVote) / SUM(r.maxVote) * 100 AS percentage')
	->leftjoin('r.assessment', 'a')
	->leftjoin('a.project', 'p')
	->andWhere('p.course = :valc')
	->setParameter('valc', $course)
	->andWhere('r.student = :val')
	->setParameter('val', $student)
	->andWhere('p.schoolYear = :val1')
	->setParameter('val1', $shoolyear)
	->andWhere('r.userVote IS NOT NULL')
	->groupBy('p.schoolYear')
	->getQuery()
	->getOneOrNullResult()
	;
}

public function getStudentResultByTopics($student)
{
	return $this->createQueryBuilder('r')

	->select('SUM(r.userVote) / SUM(r.maxVote) * 100 AS percentage, t.name, t.description')
	->leftjoin('r.assessment', 'a')
	->leftjoin('a.topic', 't')
	->andWhere('r.student = :val')
	->andWhere('t.id IS NOT NULL')
	->setParameter('val', $student)
	->andWhere('r.userVote IS NOT NULL')
	->groupBy('t.id')
	->getQuery()
	->getResult();
	;
}

public function getStudentResultBySkills($student)
{
	return $this->createQueryBuilder('r')

	->select('SUM(r.userVote) / SUM(r.maxVote) * 100 AS percentage, s.shortName, s.description')
	->leftjoin('r.assessment', 'a')
	->leftjoin('a.skill', 's')
	->andWhere('r.student = :val')
	->setParameter('val', $student)
	->andWhere('r.userVote IS NOT NULL')
	->groupBy('s.id')
	->getQuery()
	->getResult();
	;
}

public function getStudentResultByCriterion($student)
{
	return $this->createQueryBuilder('r')

	->select('SUM(r.userVote) / SUM(r.maxVote) * 100 AS percentage, c.name AS name, COUNT(r.userVote) AS nbAssessed')
	->leftjoin('r.assessment', 'a')
	->leftjoin('a.criterion', 'c')
	->andWhere('r.student = :val')
	->setParameter('val', $student)
	->andWhere('r.userVote IS NOT NULL')
	->groupBy('c.name')
	->getQuery()
	->getResult();
	;
}

public function getStudentResultBySkillsGroups($student)
{
	return $this->createQueryBuilder('r')

	->select('SUM(r.userVote) / SUM(r.maxVote) * 100 AS percentage, sg.name')
	->leftjoin('r.assessment', 'a')
	->leftjoin('a.skill', 's')
	->leftjoin('s.skillsGroup', 'sg')
	->andWhere('r.student = :val')
	->setParameter('val', $student)
	->andWhere('r.userVote IS NOT NULL')
	->groupBy('sg.id')
	->getQuery()
	->getResult();
	;
}

public function getStudentResultBySkillsGroupsAndSchoolYear($student, $schoolyear)
{
	return $this->createQueryBuilder('r')

	->select('SUM(r.userVote) / SUM(r.maxVote) * 100 AS percentage, sg.name, sg.id')
	->leftjoin('r.assessment', 'a')
	->leftjoin('a.project', 'p')
	->leftjoin('a.skill', 's')
	->leftjoin('s.skillsGroup', 'sg')
	->andWhere('r.student = :val')
	->setParameter('val', $student)
	->andWhere('p.schoolYear = :val1')
	->setParameter('val1', $schoolyear)
	->andWhere('r.userVote IS NOT NULL')
	->groupBy('sg.id')
	->getQuery()
	->getResult();
	;
}

/**
 *  Used by teacher gradebook
 */
public function getStudentResultByCourseAndSkillsGroupsAndTermAndSchoolYear($course, $student, $term_id, $schoolyear)
{
	return $this->createQueryBuilder('r')

	->select('SUM(r.userVote) / SUM(r.maxVote) * 100 AS percentage, sg.name, sg.id')
	->leftjoin('r.assessment', 'a')
	->leftjoin('a.project', 'p')
	->leftjoin('a.skill', 's')
	->leftjoin('s.skillsGroup', 'sg')
	->andWhere('p.course = :valc')
	->setParameter('valc', $course)
	->andWhere('r.student = :val')
	->setParameter('val', $student)
	->andWhere('p.schoolYear = :val1')
	->setParameter('val1', $schoolyear)
	->andWhere('p.term = :val2')
	->setParameter('val2', $term_id)
	->andWhere('r.userVote IS NOT NULL')
	->groupBy('sg.id')
	->getQuery()
	->getResult();
	;
}

public function getResultByStudentAndProject($student, $project)
{
	return $this->createQueryBuilder('r')
	
	->select('r.userVote')
	->leftjoin('r.assessment', 'a')
	->andWhere('r.student = :val')
	->setParameter('val', $student)
	->andWhere('a.project = :val1')
	->setParameter('val1', $project)
	->groupBy('r.student')
	->getQuery()
	->getOneOrNullResult()
	;
}

public function getSkillsGroupsResultByStudentAndProject($student, $project)
{
	return $this->createQueryBuilder('r')
	
	->select('SUM(r.userVote) / SUM(r.maxVote) * 100 AS percentage, sg.name')
	->leftjoin('r.assessment', 'a')
	->leftjoin('a.skill', 's')
	->leftjoin('s.skillsGroup', 'sg')
	->andWhere('r.student = :val')
	->setParameter('val', $student)
	->andWhere('a.project = :val1')
	->setParameter('val1', $project)
	->groupBy('sg.name')
	->getQuery()
	->getResult();
}


public function getSkillsGroupsResultByStudent($student, $schoolyear)
{
	return $this->createQueryBuilder('r')
	
	->select('SUM(r.userVote) / SUM(r.maxVote) * 100 AS percentage, sg.name')
	->leftjoin('r.assessment', 'a')
	->leftjoin('a.skill', 's')
	->leftjoin('s.skillsGroup', 'sg')
	->leftjoin('a.project', 'p')
	->andWhere('r.student = :val')
	->setParameter('val', $student)
	->andWhere('p.schoolYear = :val1')
	->setParameter('val1', $schoolyear)
	->groupBy('sg.name')
	->getQuery()
	->getResult();
}

}
