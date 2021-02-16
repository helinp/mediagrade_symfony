<?php

namespace App\Controller\Teacher\Results;

use App\Form\Type\SchoolYearsType;
use App\Form\Type\StudentsTopbarType;
use App\Repository\ResultRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

use App\Utils\SchoolYear;
use stdClass;

class detailledController extends AbstractController
{
    /**
     * @Route("/teacher/results/detailled/", name="teacher_results_detailled")
     */
	public function index(
        ResultRepository $resultsRepository, 
        UserRepository $userRepository, 
        Request $request
    )
	{
		// get parameters
		$schoolYear = $request->query->get('school_year');
		$student_id = $request->query->get('student_id');
		
		if (empty($schoolYear)) 
		{
			$schoolYear = SchoolYear::getSchoolYear();
		}
		$this->data['schoolyear'] = $schoolYear;
		
		// School Year form 
		$school_years = new stdClass();
		$school_years->schoolYear = $schoolYear;
		
		$schoolYearForm = $this->createForm(SchoolYearsType::class, $school_years);
        $this->data['school_year_form'] = $schoolYearForm->createView();
        
		// Students form
		$selected_student = null;
		if($student_id)
		{
			$selected_student = $userRepository->find($student_id);
		}

		$studentsForm = $this->createForm(StudentsTopbarType::class, null, ['schoolYear' => $schoolYear]);
		$studentsForm->get('id')->setData($selected_student);
        $this->data['students_form'] = $studentsForm->createView();

        if($student_id === null)
        {
			return $this->render('teacher/results/detailled/empty.html.twig', $this->data);
        }
		
		
        // get student object
        $student = $userRepository->find($student_id);

		$this->data['skills_groups_results'] = $resultsRepository->getStudentResultBySkillsGroups($student);
		$this->data['criterion_results'] = $resultsRepository->getStudentResultByCriterion($student);
		$this->data['skills_results'] = $resultsRepository->getStudentResultBySkills($student);
		$this->data['topics_results'] = $resultsRepository->getStudentResultByTopics($student);
	

		return $this->render('teacher/results/detailled/index.html.twig', $this->data);
	}
}
