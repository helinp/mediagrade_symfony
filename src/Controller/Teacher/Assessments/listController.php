<?php

namespace App\Controller\Teacher\Assessments;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Core\User\UserInterface;

use App\Repository\ProjectRepository;
use App\Entity\Project;

class listController extends AbstractController
{

	private $data = array();

	/**
	* @Route("/teacher/assessments/list", name="teacher_assessments_list")
	*/
	public function index(ProjectRepository $projectRepository, UserInterface $teacher)
	{
		$this->data['projects'] = $projectRepository->findBy(
			array('teacher' => $teacher->getId())
		);


		return $this->render('teacher/assessments/list.html.twig', $this->data);
	}


}
