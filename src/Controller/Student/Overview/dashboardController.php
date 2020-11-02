<?php

namespace App\Controller\Student\Overview;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ResultRepository;
use App\Repository\AttendanceRepository;
use App\Repository\ProjectRepository;

use Symfony\Component\Security\Core\User\UserInterface;

class dashboardController extends AbstractController
{

	public $data = array();

	public function __construct()
	{
	}


	/**
	* @Route("/student", name="student_dashboard")
	*/
	public function index(
		AttendanceRepository $attendanceRepository,
		UserInterface $student,
		ResultRepository $resultsRepository,
		ProjectRepository $projectRepository
	)
	{
		$school_year = \App\Utils\SchoolYear::getSchoolYear();
		$classe = $student->getCurrentClasse()->getClasse();

		$school_year = \App\Utils\SchoolYear::getSchoolYear();
		$this->data['attendances'] =  $attendanceRepository->getStudentAttendance($student, $school_year);

		$this->data['student'] = $student;
		$this->data['projects'] = $projectRepository->findByClasseAndSchoolyear($classe, $school_year);
		$this->data['attendance'] = $attendanceRepository->getAttendanceStatistics($school_year, $student);
		
		$terms_global_results = $resultsRepository->getStudentResultByTerms($student, $school_year);
		$this->data['terms_results'] = $terms_global_results;
		dump($terms_global_results);
		foreach ($terms_global_results as $term) 
		{
			$this->data['sg_results'][$term['term_id']] = $resultsRepository->getSkillsGroupsResultByTermAndStudent($term['term_id'], $student, $school_year);
		}
		



		return $this->render('student/dashboard/index.html.twig', $this->data);
	}

}
