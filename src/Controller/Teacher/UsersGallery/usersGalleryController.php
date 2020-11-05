<?php

namespace App\Controller\Teacher\UsersGallery;

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
	* @Route("/teacher/gallery/users/", name="teacher_users_gallery")
	*/
	public function index(
		ClasseRepository $classeRopository
		)
	{


		$this->data['classes'] = $classeRopository->findAll();
		$this->data['h1_title'] = 'Trombinoscope';

		return $this->render('teacher/users_gallery/index.html.twig', $this->data);
	}
}
