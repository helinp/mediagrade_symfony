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

use App\Utils\CustomRound;
use App\Utils\LettersVote;

use Symfony\Component\HttpFoundation\Request;

use App\Form\Type\AssessGridType;
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
			array('teacher' => $teacher->getId(), 'id' => $project_id),
		);

		$this->data['student'] = $student = $studentRepository->find($student_id);

		$this->data['submissions'] = $submissionRepository->findBy(
			array('project' => $project, 'student' => $student),
		);

		// Formuilaire
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
				dump($result);
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

		/**
		*		POST
		*/
		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
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

			$this->redirectToRoute('teacher_assessments_list');
		}

		$this->data['form'] = $form->createView();
		$this->data['assessments'] = $assessments;

		return $this->render('teacher/assessments/assess.html.twig', $this->data);
	}


}
