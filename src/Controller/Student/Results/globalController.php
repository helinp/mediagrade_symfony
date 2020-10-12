<?php

namespace App\Controller\Student\Results;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ResultRepository;
use Symfony\Component\Security\Core\User\UserInterface;

class globalController extends AbstractController
{

	public $data = array();

	public function __construct()
	{
	}


	/**
	* @Route("/student/results/", name="student_global_results")
	*/
	public function index(ResultRepository $resultsRepository, UserInterface $student)
	{

		$this->data['skills_groups_results'] = $resultsRepository->getStudentResultBySkillsGroups($student);
		$this->data['criterion_results'] = $resultsRepository->getStudentResultByCriterion($student);
		$this->data['skills_results'] = $resultsRepository->getStudentResultBySkills($student);
		$this->data['topics_results'] = $resultsRepository->getStudentResultByTopics($student);
	

		return $this->render('student/results/global.html.twig', $this->data);
	}

}
