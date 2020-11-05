<?php

namespace App\Controller\Student\Submissions;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ProjectRepository;
use App\Repository\SubmissionRepository;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use App\Entity\SubmissionFile;

use App\Form\Type\SubmissionType;


use Symfony\Component\Security\Core\Security;
use Symfony\Component\Mime\MimeTypes;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Request;

class submissionsController extends AbstractController
{

	public $data = array();

	public function __construct(Security $security)
	{
		if( ! $security->getUser()->getCurrentClasse() )
		{
			throw new  AccessDeniedException('Vous n\'êtes pas enregistré comme élève.');
		}
	}


	/**
	* @Route("/student/submissions/", name="student_submissions")
	*/
	public function index(
		ProjectRepository $projectRepository,
		UserInterface $student,
		SubmissionRepository $submissionRepository
		)
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
		$this->data['h1_title'] = 'Remise des projets';

		return $this->render('student/submissions/index.html.twig', $this->data);
	}


	/**
	* @Route("/student/submissions/submit/{project_id}", name="student_submit")
	*/
	public function submit(
		$project_id,
		ProjectRepository $projectRepository,
		Request $request,
		UserInterface $student,
		SubmissionRepository $submissionRepository
		)
	{
		$project = $projectRepository->find($project_id);

		// check if student already submitted
		$submission = $submissionRepository->findBy(['project' => $project, 'student' => $student], null, 1);


		// check if student already been graded
		// TODO

		if( isset($submission[0]) )
		{
			$submission = $submission[0];
		}
		else
		{
		// add nb required files
		for ($i = 0, $j = $project->getNumberOfFiles() ; $i < $j ; $i++)
		{				
			$submission_file = new SubmissionFile();

			// Workaround to iterate file name.
			$submission_file->i = $i;
			$submission->addSubmissionFile($submission_file);
		}
		}

		// Get mime to get file or image formtype
		$mimeTypes = new MimeTypes();
		$mimeTypes = $mimeTypes->getMimeTypes($project->getFileExtension());

		$form = $this->createForm(SubmissionType::class, $submission
		);

		// ********************
		// POST
		// ********************
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid())
		{
				// Add mandatory values
				$submission->setProject($project);
				$submission->setStudent($student);

				// Persist submission
				$em = $this->getDoctrine()->getManager();
				$em->persist($submission);

				// Persist submission files 
				$sfs = $submission->getSubmissionFiles();

				foreach($sfs as $sf)
				{
					$em->persist($sf);
				}

				$em->flush();

				return $this->redirectToRoute('student_submissions');
		}


		$this->data['submissionForm'] = $form->createView();
		$this->data['project'] = $project;
		$this->data['h1_title'] = 'Remise d\'un projet';

		return $this->render('student/submissions/submit.html.twig', $this->data);
	}
}
