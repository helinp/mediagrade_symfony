<?php

namespace App\Controller\Student\UsersGallery;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ClasseRepository;


class usersGalleryController extends AbstractController
{

	public $data = array();

	public function __construct()
	{
	}


	/**
	* @Route("/gallery/users/", name="student_users_gallery")
	*/
	public function index(
		ClasseRepository $classeRopository
		)
	{
		$this->data['classes'] = $classeRopository->findAll();
		$this->data['h1_title'] = 'Trombinoscope';

		return $this->render('student/users_gallery/index.html.twig', $this->data);
	}
}
