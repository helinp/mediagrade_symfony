<?php

namespace App\Controller\Teacher\Projects;


use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ProjectRepository;
use App\Utils\SchoolYear;

use App\Form\Type\ProjectType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Assessment;
use App\Entity\Project;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\User\UserInterface;

use Symfony\Component\HttpFoundation\Request;

class manageController extends AbstractController
{

	private $data = array();

	function __construct()
	{

	}

	/**
	* @Route("/teacher/projects/manage/{class_id}", methods="GET", defaults={"class_id"=null}, name="teacher_projects_manage")
	*/
	public function index($class_id = false, ProjectRepository $projectRepository)
	{

		$projects = null;

		if($class_id)
		{
			//			array('class_id' => $class_id, 'school_year', SchoolYear::getSchoolYear()),
			$projects = $projectRepository->findBy(
				array(),
				array('class_id' => 'ASC', 'hardDeadline' => 'DESC')
			);
		}
		else
		{
			//		array('schoolYear' => SchoolYear::getSchoolYear()),
			$projects = $projectRepository->findBy(
				array(),
				array('course' => 'ASC', 'hardDeadline' => 'DESC')
			);
		}

		if ($projects === null)
		{
			throw $this->createNotFoundException('Aucun projet trouvé.');
		}

		$this->data['projects'] = $projects;

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
				if(empty($project->getExternal)) $project->setExternal(TRUE);

				$em->persist($project);
				$em->flush();

				$request->getSession()->getFlashBag()->add('notice', 'Projet enregistré.');
			}

		$this->data['form'] = $form->createView();

		return $this->render('teacher/projects/manage/edit.html.twig', $this->data);
	}

	/**
	*  @Route("/teacher/projects/delete/{project}", name="teacher_projects_delete")
	*/
	public function delete(Project $project, UserInterface $user): RedirectResponse
	{
		// Checks if user has property on project

		if($user = $project->getTeacher())
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
}
