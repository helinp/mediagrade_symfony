<?php

namespace App\Controller\Teacher\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Core\User\UserInterface;

use App\Repository\ProjectRepository;
use App\Entity\Project;
use App\Repository\AssessmentRepository;
use App\Repository\CriterionRepository;
use App\Repository\ResultRepository;
use App\Repository\SubmissionRepository;
use Symfony\Component\HttpFoundation\Request;

class apiController extends AbstractController
{

	private $data = array();

    /**
     * @Route("/teacher/api/criterion", methods="GET", name="admin_criterion_list")
     */
    public function getcriterion(
		CriterionRepository $criterionRepository, 
		Request $request)
    {
		$criterion = $criterionRepository->findAllMatching($request->query->get('query'));

        return $this->json(
            $criterion
        , 200, [], []);
    }
    /**
     * @Route("/teacher/api/indicator", methods="GET", name="admin_indicator_list")
     */
    public function getIndicators(
		AssessmentRepository $assessmentRepository, 
		Request $request)
    {
		$indicators = $assessmentRepository->findAllMatchingIndicators($request->query->get('query'));

        return $this->json(
            $indicators
        , 200, [], []);
    }
}


