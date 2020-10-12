<?php

namespace App\Controller\Teacher\GradeBook;

use App\Form\Type\TermsType;
use App\Form\Type\CoursesTopbarType;
use App\Form\Type\SchoolYearsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Core\User\UserInterface;

use App\Utils\SchoolYear;

use App\Repository\ProjectRepository;
use App\Repository\CourseRepository;
use App\Repository\ResultRepository;
use App\Repository\SkillsGroupRepository;
use App\Repository\TermRepository;
use stdClass;
use Symfony\Component\HttpFoundation\Request;

class gradeBookController extends AbstractController
{

	private $data = array();

	/**
	 * @Route("/teacher/gradebook/{course_id}/{term_id}", defaults={"course_id"=null, "term_id"=null}, name="teacher_grade_book")
	 */
	public function index(
		$course_id,
		$term_id,
		UserInterface $teacher,
		Request $request,
		ProjectRepository $projectRepository,
		TermRepository $termRepository,
		CourseRepository $courseRepository,
		SkillsGroupRepository $skillsGroupRepository,
		ResultRepository $resultRepository
	) {

		/**
		 * Get User FILTERS 
		 */

		// get school Year
		$schoolYear = $request->query->get('school_year');
		if (empty($schoolYear)) {
			$schoolYear = SchoolYear::getSchoolYear();
		}
		$this->data['schoolyear'] = $schoolYear;

		// Select first course as defaut view
		if ($course_id === null) {
			return $this->redirectToRoute('teacher_grade_book', ['course_id' => 1]);
		} else {
			$this->data['course'] = $course = $courseRepository->find($course_id);
		}

		// Terms 
		$terms = new stdClass();
		if ($term_id) {

			$terms->id = $termRepository->find($term_id);
		} else {
			$terms->id = null;
		}
		$termForm = $this->createForm(TermsType::class, $terms);
		$this->data['term_form'] = $termForm->createView();

		// Terms 
		$school_years = new stdClass();
		$school_years->schoolYear = $schoolYear;

		$schoolYearForm = $this->createForm(SchoolYearsType::class, $school_years);
		$this->data['school_year_form'] = $schoolYearForm->createView();

		// Courses 
		$courses = new stdClass();
		if ($course_id) {
			$courses->id = $courseRepository->find($course_id);
		} else {
			$courses->id = null;
		}
		$coursesForm = $this->createForm(CoursesTopbarType::class, $courses);
		$this->data['courses_form'] = $coursesForm->createView();

		// TODO: result by skill
		// TODO Result total 
		if ($term_id) {
			$this->data['projects'] = $projects = $projectRepository->findBy(
				array(
					'teacher' => $teacher->getId(),
					'course' => $course,
					'schoolYear' => $schoolYear,
					'term' => $term_id
				)
			);
		} else {
			$this->data['projects'] = $projects = $projectRepository->findBy(
				array(
					'teacher' => $teacher->getId(),
					'course' => $course,
					'schoolYear' => $schoolYear,
				)
			);
		}

		$this->data['skills'] = $skillsGroupRepository->findAll();
		$this->data['school_year'] = $schoolYear;

		// totals 
		$students = $course->getClasse()->getCurrentStudents($schoolYear);
		$totals = array();
		$skillsGroupsTotal = array();

		if ($term_id) 
		{

			foreach ($students as $student) 
			{
				$totals[$student->getId()] = $resultRepository->getStudentResultByTerm($student, $schoolYear, $term_id);
				$skillsGroupsTotal[$student->getId()] = $resultRepository->getStudentResultBySkillsGroupsAndTermAndSchoolYear($student, $term_id, $schoolYear);
			}
			
			$this->data['totals_terms'] = $totals;
		} 
		else 
		{
			
			foreach ($students as $student) 
			{
				$skillsGroupsTotal[$student->getId()] = $resultRepository->getStudentResultBySkillsGroupsAndSchoolYear($student, $schoolYear);
				$totals[$student->getId()] = $resultRepository->getStudentResultBySchoolyear($student, $schoolYear);
			}

			$this->data['totals'] = $totals;
		}
		
		
		$this->data['sg_totals'] = $skillsGroupsTotal;
		dump($skillsGroupsTotal);

		//dump($projects);
		//dump(\App\Utils\GradeBook::getGradeBook($projects, $course)); 

		return $this->render('teacher/grade_book/index.html.twig', $this->data);
	}
}
