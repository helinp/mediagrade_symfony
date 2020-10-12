<?php

namespace App\Controller\Student\Results;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ProjectRepository;
use App\Repository\SubmissionRepository;
use App\Repository\StudentClasseRepository;
use Symfony\Component\Security\Core\User\UserInterface;

use App\Utils\SchoolYear;

class simplifiedController extends AbstractController
{

	public $data = array();

	public function __construct()
	{
	}


	/**
	* @Route("/student/results/projects", name="student_simplified_results")
	*/
	public function index(
		ProjectRepository $projectRepository,
		UserInterface $student,
		SubmissionRepository $submissionRepository,
		StudentClasseRepository $studentClasseRepository)
	{

		// get current student classe and courses
		// TODO Should be in session info

		// Workaround to get all courses projects
		$courses = $student->getCurrentClasse()->getClasse()->getCourses();
		$courses_id = array();
		foreach ($courses as $course)
		{
			$courses_id[] = $course->getId();
		}

		$projects = $projectRepository->findBy(
				array('course' => $courses_id),
				array('hardDeadline' => 'DESC')
			);

		$school_year = \App\Utils\SchoolYear::getSchoolYear();
		$classe = $student->getCurrentClasse()->getClasse();
		$projects = $projectRepository->findByClasseAndSchoolyear($classe, $school_year);

		$this->data['submissions'] = $submissionRepository->findBy(
				array('project' => $projects, 'student' => $student),
		);

		$this->data['projects'] = $projects;
		$this->data['student'] = $student;
		$this->data['h1_title'] = 'Résultats des projets';

		return $this->render('student/results/simplified.bak.html.twig', $this->data);
	}

}
