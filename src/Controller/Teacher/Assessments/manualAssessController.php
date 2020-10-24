<?php

namespace App\Controller\Teacher\Assessments;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Core\User\UserInterface;

use App\Repository\ProjectRepository;
use App\Repository\AssessmentRepository;
use App\Repository\UserRepository;
use App\Repository\SubmissionRepository;
use App\Repository\ResultRepository;

use App\Entity\Assessment;
use App\Entity\Result;
use App\Entity\StudentClasse;
use App\Form\Type\AssessGridManualType;
use App\Utils\CustomRound;
use App\Utils\LettersVote;

use Symfony\Component\HttpFoundation\Request;

use App\Form\Type\AssessSuperGridManualType;
use stdClass;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class manualAssessController extends AbstractController
{

	private $data = array();

	
	/**
	* @Route("/teacher/assessments/manual/list/", name="teacher_manual_assess_list")
	*/
	public function list(

		ProjectRepository $projectRepository,
		UserInterface $teacher,
		Request $request
		)
	{
		$this->data['projects'] = $projectRepository->findBy(
			[
				'teacher' => $teacher, 
				'external' => true, 
				'schoolYear' => \App\Utils\SchoolYear::getSchoolYear()
			],
		['course' => 'ASC', 'startDate' => 'DESC']	);


		return $this->render('teacher/assessments/manual_list.html.twig', $this->data);

	}


	/**
	* @Route("/teacher/assessments/manual/{project_id}/", name="teacher_manual_assess")
	*/
	public function index(
		$project_id,
		assessmentRepository $assessmentRepository,
		ProjectRepository $projectRepository,
		ResultRepository $resultRepository,
		UserInterface $teacher,
		Request $request
		)
	{

		// données du projet
		$this->data['project'] = $project = $projectRepository->findOneBy(
			array('teacher' => $teacher->getId(), 'id' => $project_id),
		);		
		
		// Students
		$studentsClasse =  $project->getCourse()->getClasse()->getCurrentStudents();

		// Critères d'évaluation pour formulaire
		$assessments = $assessmentRepository->findBy(
			array('project' => $project_id)
		);

		// twig view 
		$this->data['assessments'] = $assessments;


		$gridResults  = array();
		
		foreach ($studentsClasse as $student)
		{
			// Ensure it is an entity/user object
			$student = $student->getStudent();
			
			// View twig
			$this->data['students'][] = $student;
			
			
			$results = array();
			foreach ($assessments as $assessment)
			{
				$current_result = $resultRepository->findOneBy(
					array('assessment' => $assessment, 'student' => $student),
				);
				
				if( $current_result == null )
				{
					$result = new Result();
					$result->setAssessment($assessment);
					$result->setStudent($student);
					$result->setMaxVote($assessment->getMaxVote());
				}
				else
				{
					$result = $current_result;
				}
				$results[] = $result;
				
			}
			$gridResults['students'][] = ['results' => $results];
		
		}
		//$gridResults = $gridResults;


		$form = $this->createForm(AssessSuperGridManualType::class, $gridResults)
				
			->add('save', SubmitType::class, [
				'attr' => ['class' => 'btn btn-danger'],
				'label' => 'Enregistrer l\'évaluation'
				]);

		/**
		*		POST
		*/
		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
		{
			$em = $this->getDoctrine()->getManager();

			//$gridResults = array_column($gridResults['results'], 'results');
			
			foreach ($gridResults as $students)
			{			
				foreach ($students as $student)
				{
					foreach ($student as $results)
					{
						foreach ($results as $result)
						{
							if($result->getUserLetter() !== null OR $result->getUserVote() !== null )
							{


								$result->setDate(new \DateTime());

								if($result->getAssessment()->getGradingSystem()->getId() === Assessment::GRADING_POINTS)
								{
									$result->setUserLetter(null);
								
								}
								else
								{
									$numeric_result = LettersVote::getNumericFromLetterVote($result->getUserLetter());
									$customVote = CustomRound::CustomRound($numeric_result);
									$result->setUserVote($customVote + .0);

								}
								$em->persist($result);
							}
						}
					}
				}
			}
			$em->flush();

			$request->getSession()->getFlashBag()->add('notice', 'Évaluation enregistrée.');

			return $this->redirectToRoute('teacher_manual_assess_list');
		}

		$this->data['form'] = $form->createView();
		$this->data['assessments'] = $assessments;

		return $this->render('teacher/assessments/manual.html.twig', $this->data);
	}


}
