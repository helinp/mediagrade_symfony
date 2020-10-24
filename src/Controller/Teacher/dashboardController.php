<?php

namespace App\Controller\Teacher;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Utils\SchoolYear;
use App\Entity\Project;
use App\Repository\ProjectRepository;
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

		//		array('schoolYear' => SchoolYear::getSchoolYear()),
		$projects = $projectRepository->findBy(
			array('teacher' => $teacher->getId(), 'schoolYear' => SchoolYear::getSchoolYear()),
			array('course' => 'ASC', 'hardDeadline' => 'DESC')
		);

		$this->data['projects'] = $projects;
		return $this->render('teacher/dashboard/index.html.twig', $this->data);
	}


// change schoolyear




}
