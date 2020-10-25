<?php

namespace App\Controller\Teacher\Attendance;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Core\User\UserInterface;

use Symfony\Component\HttpFoundation\Request;

use App\Repository\CourseRepository;
use App\Repository\StudentClasseRepository ;
use App\Repository\AttendanceGridRepository;

use App\Form\Type\AttendancesGridType;

use App\Entity\Attendance;
use App\Entity\AttendanceGrid;

class attendanceController extends AbstractController
{

	private $data = array();

	/**
	* @Route("/teacher/attendance/", name="teacher_attendance_index")
	*/
	public function index(
		AttendanceGridRepository $attendanceGridRepository,
		UserInterface $teacher,
		CourseRepository $courseRepository
		)
		{
			$school_year = \App\Utils\SchoolYear::getSchoolYear();

			$this->data['attendancesGrid'] = $attendanceGridRepository->findBy(['schoolYear' => $school_year, "teacher" => $teacher], ['date' => 'DESC', 'schoolHour' => 'ASC']);
			$this->data['courses'] = $courseRepository->findBy(['teacher' => $teacher], ['name' => 'ASC']);

			return $this->render('teacher/attendance/index.html.twig', $this->data);
		}

		/**
		* @Route("/teacher/attendance/{action}/{course_id}/{attendance_grid_id}", defaults={"attendance_grid_id"=null, "course_id"=null}, name="teacher_attendance_new", requirements={"action"="edit|new"})
		*/
		public function new(
			$course_id = null,
			$action,
			$attendance_grid_id = null,
			UserInterface $teacher,
			CourseRepository $courseRepository,
			AttendanceGridRepository $attendanceGridRepository,
			StudentClasseRepository $studentClasseRepository,
			Request $request
			)
			{
				$school_year = \App\Utils\SchoolYear::getSchoolYear();

				if($action === 'new')
				{
					// GET STUDENTS
					$course = $courseRepository->find($course_id);
					$classe = $course->getClasse();
					$students = $studentClasseRepository->findBy(['classe' => $classe, 'schoolyear' => $school_year]);
					$this->data['students'] = $students;

					$attendanceGrid = new AttendanceGrid();
					$attendanceGrid->setTeacher($teacher);
					$attendanceGrid->setSchoolYear($school_year);
					$attendanceGrid->setCourse($course);

					foreach ($students as $student)
					{
						$attendance = new Attendance();
						$s = $student->getStudent();
						$attendance->setStudent($s);
						
						// default choice
						$attendance->setStatus('P');

						$attendanceGrid->addAttendance($attendance);
					}
				}
				elseif ($action === 'edit')
				{
					$attendanceGrid = $attendanceGridRepository->find($attendance_grid_id);
				}

				$form = $this->createForm(AttendancesGridType::class, $attendanceGrid);

				$form->handleRequest($request);

				if ($form->isSubmitted() && $form->isValid())
				{
					$attendanceGrid = $form->getData();
					$attendanceGrid->setDateTime(new \DateTimeImmutable());

					// TODO: SECURITY Check if teacher is logged

					$em = $this->getDoctrine()->getManager();
					$em->persist($attendanceGrid);
					$em->flush();

					$request->getSession()->getFlashBag()->add('notice', 'Présences enregistrées.');
					return $this->redirectToRoute('teacher_attendance_index');
				}

				$this->data['form'] = $form->createView();
				return $this->render('teacher/attendance/new.html.twig', $this->data);

			}


		}
