<?php

namespace App\Controller\Teacher\Results;

use App\Form\Type\SchoolYearsType;
use App\Form\Type\StudentsTopbarType;
use App\Repository\ProjectRepository;
use App\Repository\ResultRepository;
use App\Repository\SubmissionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Utils\SchoolYear;
use stdClass;

class simplifiedController extends AbstractController
{

    /**
     * @Route("/teacher/results/simplified/", name="teacher_results_simplified")
     */
    public function index(
        Request $request, 
        ProjectRepository $projectRepository,
        ResultRepository $resultRepository,
        SubmissionRepository $submissionRepository,
        UserRepository $userRepository
    ) {
		// get parameters
		$schoolYear = $request->query->get('school_year');
		$student_id = $request->query->get('student_id');;
		
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
            return $this->render('teacher/results/simplified/empty.html.twig', $this->data);
        }
              
        // get student object
        $student = $userRepository->find($student_id);

        // Get projects
        $classe = $student->getCurrentClasse()->getClasse();
        $projects = $projectRepository->findByClasseAndSchoolyear($classe, $schoolYear);

        // Get results for each projects 
        $projects_result_sg = array();
        foreach ($projects as $project) {
            $projects_result_sg[$project->getId()] = $resultRepository->getSkillsGroupsResultByStudentAndProject($student->getId(), $project->getId());
        }
        $this->data['results_sg'] = $projects_result_sg;

        // Get submissions
        $this->data['submissions'] = $submissionRepository->findBy(
            array('project' => $projects, 'student' => $student),
        );

        $this->data['projects'] = $projects;
        $this->data['student'] = $student;
        $this->data['h1_title'] = 'Résultats des projets';

        return $this->render('teacher/results/simplified/index.html.twig', $this->data);
    }
}
