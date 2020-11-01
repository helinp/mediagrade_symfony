<?php

namespace App\Controller\Student\Results;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ProjectRepository;
use App\Repository\ResultRepository;
use App\Repository\SubmissionRepository;
use Symfony\Component\Security\Core\User\UserInterface;


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
		ResultRepository $resultRepository,
		SubmissionRepository $submissionRepository
		)
	{

		// Get projects
		$school_year = \App\Utils\SchoolYear::getSchoolYear();
		$classe = $student->getCurrentClasse()->getClasse();
		$projects = $projectRepository->findByClasseAndSchoolyear($classe, $school_year);

		// Get results for each projects 
		$projects_result_sg = array();
		foreach ($projects as $project) 
		{
			$projects_result_sg[$project->getId()] = $resultRepository->getSkillsGroupsResultByStudentAndProject($student->getId(), $project->getId());
		}
		$this->data['results_sg'] = $projects_result_sg;

		// Get submissions
		$this->data['submissions'] = $submissionRepository->findBy(
				array('project' => $projects, 'student' => $student),
		);

		$this->data['projects'] = $projects;
		$this->data['student'] = $student;
		$this->data['h1_title'] = 'Résultats des projets';

		return $this->render('student/results/simplified.html.twig', $this->data);
	}

}
