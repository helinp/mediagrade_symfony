<?php

namespace App\Controller\Teacher\Assessments;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Core\User\UserInterface;

use App\Repository\ProjectRepository;
use App\Entity\Project;
use App\Repository\ResultRepository;
use App\Repository\SubmissionRepository;

class listController extends AbstractController
{

	private $data = array();

	/**
	* @Route("/teacher/assessments/list", name="teacher_assessments_list")
	*/
	public function index(
		ProjectRepository $projectRepository, 
		UserInterface $teacher,
		ResultRepository $resultRepository,
		SubmissionRepository $submissionRepository
		)
	{

		$school_year = \App\Utils\SchoolYear::getSchoolYear();
		
		$this->data['projects'] = $projects = $projectRepository->findBy(
			array('teacher' => $teacher->getId(), 
			'schoolYear' => $school_year),
			
			array(
				'course' => 'ASC', 
				'startDate' => 'DESC'
			)
		);


		// status 
		$status = array();
		foreach($projects as $project)
		{
			$students = $project->getCourse()->getClasse()->getCurrentStudents();
			foreach($students as $student)
			{
				$student = $student->getStudent();
				$status[$project->getId()][$student->getId()]['submission'] = $submissionRepository->getSubmissionByStudentAndProject($student, $project);
				$status[$project->getId()][$student->getId()]['result'] = $resultRepository->getResultByStudentAndProject($student, $project);
			}
		}
		$this->data['status'] = $status;

		return $this->render('teacher/assessments/list.html.twig', $this->data);
	}


}
