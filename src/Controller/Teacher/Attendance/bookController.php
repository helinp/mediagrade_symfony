<?php

namespace App\Controller\Teacher\Attendance;

use App\Form\Type\CoursesTopbarType;
use App\Form\Type\SchoolYearsType;
use App\Form\Type\TermsType;
use App\Repository\AttendanceGridRepository;
use App\Repository\AttendanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Core\User\UserInterface;

use Symfony\Component\HttpFoundation\Request;

use App\Repository\CourseRepository;
use App\Utils\SchoolYear;
use App\Repository\TermRepository;
use stdClass;

class bookController extends AbstractController
{

	private $data = array();

	/**
	* @Route("/teacher/attendance/book/{course_id}/{term_id}", defaults={"course_id"=null, "term_id"=null}, name="teacher_attendance_book")
	*/
	public function index(
		$course_id,
		$term_id,
		CourseRepository $courseRepository,
		TermRepository $termRepository,
		AttendanceRepository $attendanceRepository,
		AttendanceGridRepository $attendanceGridRepository,
		Request $request,
		UserInterface $teacher
	) 
	{

		/**
		 * Get User FILTERS 
		 * TODO : Make a service? 
		 */

		// get school Year
		$schoolYear = $request->query->get('school_year');
		if (empty($schoolYear)) {
			$schoolYear = SchoolYear::getSchoolYear();
		}
		$this->data['schoolyear'] = $schoolYear;

		// Select first course as defaut view
		if ($course_id === null) {
			return $this->redirectToRoute('teacher_attendance_book', ['course_id' => 1]);
		} else {
			$this->data['course'] = $course = $courseRepository->find($course_id);
		}

		// SchoolYear 
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


		$this->data['school_year'] = $schoolYear;
		
		// Get students
		$this->data['students'] = $course->getClasse()->getCurrentStudents($schoolYear);
		
		// Get attendances 
		$this->data['attendanceGrids'] = $attendanceGridRepository->findBy(
			['course' => $course_id, 'teacher' => $teacher], 
			["date" => "ASC", "schoolHour" => "ASC"]
		);
		

		return $this->render('teacher/attendance/book.html.twig', $this->data);
	}
}
