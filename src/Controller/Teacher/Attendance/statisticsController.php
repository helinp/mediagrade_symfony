<?php

namespace App\Controller\Teacher\Attendance;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Core\User\UserInterface;

use Symfony\Component\HttpFoundation\Request;

use App\Repository\CourseRepository;
use App\Repository\StudentClasseRepository ;
use App\Repository\AttendanceRepository;


class statisticsController extends AbstractController
{

	private $data = array();

	/**
	* @Route("/teacher/attendance/statistics", name="teacher_attendance_statistics")
	*/
	public function index(
		StudentClasseRepository $studentClasseRepository,
		UserInterface $teacher
		)
		{
			$school_year = \App\Utils\SchoolYear::getSchoolYear();

			$this->data['attendances'] = $studentClasseRepository->getAttendanceStatistics($school_year);

			return $this->render('teacher/attendance/statistics.html.twig', $this->data);
		}

		}
