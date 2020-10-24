<?php

namespace App\Controller\Teacher\Setup;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\User;
use App\Entity\StudentClasse;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

use App\Form\Type\NewStudentType;
use Symfony\Component\HttpFoundation\Request;


class studentsController extends AbstractController
{

	private $passwordEncoder;
	public function __construct(UserPasswordEncoderInterface $passwordEncoder)
	{
		$this->passwordEncoder = $passwordEncoder;
	}


	/**
	* @Route("/teacher/setup/students", name="teacher_students")
	*/
	public function index(Request $request, UserRepository $userRepository, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder)
	{
		$school_year = \App\Utils\SchoolYear::getSchoolYear();
		//
		// GET ALL USERS
		//
		$users = $userRepository->findAllStudents($school_year);
		$this->data['users'] = $users;
		$old_users = $userRepository->findAllOldStudents($school_year);
		$this->data['old_users'] = $old_users;

		//
		// FORM
		//
		$user = new User();

		// standard password
		$user->setPassword('itp');
		$user->setActive(true);

		$studentClasse = new StudentClasse();
		$studentClasse->setSchoolyear(\App\Utils\SchoolYear::getSchoolYear());

		$user->addStudentClass($studentClasse);

		// create form
		$form = $this->createForm(NewStudentType::class, $user);

		$this->data['form'] = $form->createView();
;

		/**
		*		POST
		*/
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid())
		{
			// Encodes password
			$password = $passwordEncoder->encodePassword($user, $user->getPassword());
			$user->setPassword($password);

			// Sets student role
			$user->setRoles( array('ROLE_STUDENT') );

			$em->persist($user);
			$em->flush();

			$this->addFlash('success', 'Utilisateur ajouté!');
			$this->redirect('/teacher/setup/students');
		}

		return $this->render('teacher/students/index.html.twig', $this->data);
	}

	/**
	* @Route("/teacher/setup/students/edit/{id}",  name="teacher_students_edit")
	*/
	public function edit(User $user, Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder)
	{
		// If current classe is set to this schoolyear
		$current_school_year = \App\Utils\SchoolYear::getSchoolYear();

		if($user->getCurrentClasse() === false OR $user->getCurrentClasse()->getSchoolYear() !== $current_school_year)
		{
			$student_class = new StudentClasse();
			$student_class->setSchoolYear($current_school_year);
			$user->addStudentClass($student_class);
		}


		$form = $this->createForm(NewStudentType::class, $user);
		$this->data['form'] = $form->createView();
		$this->data['user'] = $user;

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid())
		{
			 /** @var User $user */
			$user = $form->getData();
			// Encodes password
			if( ! empty($user->getPassword()))
			{
				$password = $passwordEncoder->encodePassword($user, $user->getPassword());
				$user->setPassword($password);
			}

			$em->persist($user);
			$em->flush();

			$this->addFlash('success', 'Utilisateur modifié!');
			return $this->redirectToRoute('teacher_students');
		}

		return $this->render('teacher/students/modal_edit.html.twig', $this->data);
	}



}
