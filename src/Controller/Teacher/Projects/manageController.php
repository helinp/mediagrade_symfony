<?php

namespace App\Controller\Teacher\Projects;

use App\Form\Type\CoursesTopbarType;
use App\Form\Type\SchoolYearsType;
use App\Form\Type\ProjectType;


use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Request;

use App\Utils\SchoolYear;

use App\Repository\CourseRepository;
use App\Repository\ProjectRepository;

use App\Entity\Assessment;
use App\Entity\Project;

use stdClass;

class manageController extends AbstractController
{

	private $data = array();

	function __construct()
	{

	}

	/**
	* @Route("/teacher/projects/manage/{course_id}", methods="GET", defaults={"course_id"=null}, name="teacher_projects_manage")
	*/
	public function index(
		$course_id = false, 
		ProjectRepository $projectRepository, 
		Request $request, 
		CourseRepository $courseRepository,
		UserInterface $teacher
		)
	{

		// get school Year
		$schoolYear = $request->query->get('school_year');
		if (empty($schoolYear)) 
		{
			$schoolYear = SchoolYear::getSchoolYear();
		}
		$this->data['schoolyear'] = $schoolYear;

		$school_years = new stdClass();
		$school_years->schoolYear = $schoolYear;

		$schoolYearForm = $this->createForm(SchoolYearsType::class, $school_years);
		$this->data['school_year_form'] = $schoolYearForm->createView();

		// Courses selector
		if ($course_id)
		{
			$courses = $courseRepository->find($course_id);
		} 
		else 
		{
			$courses = $teacher->getOrderedCourses();
			$course_id = null;
		}
		$coursesForm = $this->createForm(CoursesTopbarType::class, $course_id);
		$this->data['courses_form'] = $coursesForm->createView();

		$this->data['courses'] = $courses;

		return $this->render('teacher/projects/manage/index.html.twig', $this->data);
	}

	/**
	*  @Route("/teacher/projects/{action}/{project_id}", methods="GET|POST", defaults={"project_id"=null}, requirements={"action"="edit|new"}, name="teacher_projects_edit")
	*/
	public function edit(string $action, int $project_id = null, Request $request, ProjectRepository $projectRepository, UserInterface $teacher)
	{
		/**
		* GET
		*/
		if($action === 'edit')
		{
			$h1_title = 'Modifier le projet';
			$project = $projectRepository->find($project_id);

			if ( ! $project)
			{
				throw $this->createNotFoundException('Aucun projet trouvé.');
			}

			if( empty($project->getAssessments()[0]) )
			{
				$project->addAssessment( new Assessment());
			}

			// Used for delete button
			$this->data['project'] = $project;
		}
		else
		{
			$h1_title = 'Créer un nouveau projet';
			$project = new Project();
			$project->addAssessment( new Assessment());
		}


		$form = $this->createForm(ProjectType::class, $project)
		->add('save', SubmitType::class, [
				'attr' => ['class' => 'btn btn-danger'],
				'label' => ($action === 'edit' ? 'Sauver les modifications' : 'Enregistrer le projet')
			]);

			/**
			*		POST
			*/
			if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
			{
				$em = $this->getDoctrine()->getManager();

				// Mandatory fields
				$project->setSchoolYear(\App\Utils\SchoolYear::getSchoolYear());
				$project->setActivated(TRUE);
				$project->setTeacher($teacher);
				if(empty($project->getExternal)) $project->setExternal(FALSE);

				$em->persist($project);
				$em->flush();

				$request->getSession()->getFlashBag()->add('notice', 'Projet enregistré.');
				return $this->redirectToRoute('teacher_projects_manage');
			}

		$this->data['h1_title'] = $h1_title;
		$this->data['form'] = $form->createView();

		return $this->render('teacher/projects/manage/edit.html.twig', $this->data);
	}

	/**
	*  @Route("/teacher/projects/delete/{project}", name="teacher_projects_delete")
	*/
	public function delete(Project $project, UserInterface $user): RedirectResponse
	{
		// Checks if user has property on project

		if($user == $project->getTeacher())
		{
			$em = $this->getDoctrine()->getManager();
			$em->remove($project);
			$em->flush();
			return $this->redirectToRoute('teacher_projects_manage');
		}
		else
		{
			throw new Exception("Access unauthorized", 1);
		}

	}
	/**
	*  @Route("/teacher/projects/duplicate/{project}", name="teacher_projects_duplicate")
	*/
	public function duplicate(Project $project, UserInterface $user): RedirectResponse
	{
		// Checks if user has property on project

		if($user == $project->getTeacher())
		{
			$em = $this->getDoctrine()->getManager();
			
			$assessments = $project->getAssessments();

			$project = clone($project);

			// Force current school Year
			$project->setSchoolYear(\App\Utils\SchoolYear::getSchoolYear());

			// Default values
			if(empty($project->getExternal)) $project->setExternal(FALSE);

			// Relink assessments 
			foreach($assessments as $assessment)
			{
				$assessment = clone($assessment);
				$project->addAssessment($assessment);		
			}

			$em->persist($project);
			$em->flush();

			return $this->redirectToRoute('teacher_projects_manage');
		}
		else
		{
			throw new Exception("Access unauthorized", 1);
		}

	}
}
