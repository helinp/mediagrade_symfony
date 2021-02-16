<?php

namespace App\Controller\Teacher;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Utils\SchoolYear;

use App\Repository\ProjectRepository;
use DateTime;
use Symfony\Component\Security\Core\User\UserInterface;

class dashboardController extends AbstractController
{

	private $data = array();

	public function __construct()
	{
	}


	/**
	* @Route("/teacher", name="teacher_dashboard")
	*/
	public function index(ProjectRepository $projectRepository, UserInterface $teacher)
	{

		$schoolYear = \App\Utils\SchoolYear::getSchoolYear();

		$projects = $projectRepository->getCurrentProjects($teacher, $schoolYear);

		$this->data['projects'] = $projects;
		return $this->render('teacher/dashboard/index.html.twig', $this->data);
	}


// change schoolyear




}
