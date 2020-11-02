<?php

namespace App\Controller\Common;


use App\Repository\SubmissionFileRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class galleryController extends AbstractController
{

	public $data = array();

	public function __construct()
	{
	}


	/**
	 * @Route("/gallery/all", name="gallery")
	 */
	public function index(
		SubmissionFileRepository $submissionFileRepository,
		Request $request, 
		PaginatorInterface $paginator
		)
	{
		$submissions = $submissionFileRepository->findAllGallery();

		$this->data['gallerie'] = $paginator->paginate(
            $submissions,
            $request->query->getInt('page', 1),
           12
		);
		

		return $this->render('common/gallery/index.html.twig', $this->data);
	}

	/**
	 * @Route("/gallery/perso", name="my_gallery")
	 */
	public function my(
		SubmissionFileRepository $submissionFileRepository,
		Request $request, 
		PaginatorInterface $paginator,
		UserInterface $student
		)
	{
		$submissions = $submissionFileRepository->findAllGalleryByStudent($student);

		$this->data['gallerie'] = $paginator->paginate(
            $submissions,
            $request->query->getInt('page', 1),
           12
		);

		return $this->render('common/gallery/index.html.twig', $this->data);
	}


}
