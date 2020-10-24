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

use App\Entity\Project;
use App\Entity\Assessment;
use App\Entity\Result;
use App\Entity\Submission;
use App\Entity\SubmissionFile;
use App\Form\Type\AssessGridManualType;
use App\Utils\CustomRound;
use App\Utils\LettersVote;

use Symfony\Component\HttpFoundation\Request;

use App\Form\Type\AssessGridType;
use App\Form\Type\SubmissionType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class assessController extends AbstractController
{

	private $data = array();

	/**
	* @Route("/teacher/assessments/assess/{project_id}/{student_id}", name="teacher_assess")
	*/
	public function index(
		$project_id, $student_id,
		assessmentRepository $assessmentRepository,
		submissionRepository $submissionRepository,
		ProjectRepository $projectRepository,
		ResultRepository $resultRepository,
		UserRepository $studentRepository,
		UserInterface $teacher,
		Request $request
		)
	{

		$this->data['project'] = $project = $projectRepository->findOneBy(
			array(
				'teacher' => $teacher->getId(), 
				'id' => $project_id
				)
		);

		$this->data['student'] = $student = $studentRepository->find($student_id);


		/**
		*		Formulaire d'évaluation
		*/
		$assessments = $assessmentRepository->findBy(
			array('project' => $project_id)
		);

		$results = array();
		foreach ($assessments as $assessment)
		{
			$current_result = $resultRepository->findOneBy(
				array('assessment' => $assessment, 'student' => $student),
			);

			if( $current_result === null )
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

		$data = ['results' => $results];

		$form = $this->createForm(AssessGridType::class, $data)
		->add('save', SubmitType::class, [
			'attr' => ['class' => 'btn btn-danger'],
			'label' => 'Enregistrer l\'évaluation'
		]);
		$this->data['form'] = $form->createView();

		/**
		*		Get student submission, if any 
		*/
		$this->data['submissions'] = $submissionRepository->findBy(
			array('project' => $project, 'student' => $student),
		);

		/**
		*		SUBMISSION FORM 
		*/

		$teacher_submission = new Submission();

		// add nb required files
		for ($i = 0, $j = $project->getNumberOfFiles() ; $i < $j ; $i++)
		{				
			$submission_file = new SubmissionFile();

			// Workaround to iterate file name.
			$submission_file->i = $i;
			$teacher_submission->addSubmissionFile($submission_file);
		}
		$submission_form = $this->createForm(SubmissionType::class, $teacher_submission);			
		$this->data['submission_form'] = $submission_form->createView();

		/**
		*		POST SUBMISSION
		*/
		$submission_form->handleRequest($request);
		if ($request->isMethod('POST') 
		&& $submission_form->isSubmitted() 
		&& $submission_form->isValid()
		)
		{
				// Add mandatory values
				$teacher_submission->setProject($project);
				$teacher_submission->setStudent($student);

				// Persist submission
				$em = $this->getDoctrine()->getManager();
				$em->persist($teacher_submission);
				
				// Persist submission files 
				$sfs = $teacher_submission->getSubmissionFiles();

				foreach($sfs as $sf)
				{
					$em->persist($sf);
				}
				$em->flush();
		}

		/**
		*		POST ASSESSMENT
		*/
		$form->handleRequest($request);
		if ($request->isMethod('POST') 
			&& $form->isSubmitted() 
			&& $form->isValid()
		)
		{
			$em = $this->getDoctrine()->getManager();

			foreach ($data['results'] as $result)
			{
				/* TODO: Implement points system */
				

				/* Convert Letter to numeric vote */
				$numeric_result = LettersVote::getNumericFromLetterVote($result->getUserLetter());

				if(is_numeric($numeric_result))
				{
					$customVote = CustomRound::customVote($numeric_result, $result->getMaxVote());
					$result->setUserVote($customVote + .0);
				}
				else
				{
					$result->setUserVote(null);
				}

				$result->setDate(new \DateTime());

				$em->persist($result);
			}
			$em->flush();

			$request->getSession()->getFlashBag()->add('notice', 'Évaluation enregistrée.');

			return $this->redirectToRoute('teacher_assessments_list');
		}





		$this->data['assessments'] = $assessments;

		return $this->render('teacher/assessments/assess.html.twig', $this->data);
	}


}
