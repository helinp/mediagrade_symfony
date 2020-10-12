<?php

namespace App\Controller\Common;

use App\Entity\UserAvatar;
use App\Form\Type\ProfileType;
use App\Form\Type\ProfilePasswordType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Security\Core\Security;

class profileController extends AbstractController
{

	public $data = array();

	public function __construct(Security $security)
	{
		$this->security = $security;
	}


	/**
	 * @Route("/profile/", name="user_profile")
	 */
	public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder, UserRepository $userRepository)
	{

		$user = $this->security->getUser();

		// Get rid of serializazion issue => get user entity
		$user = $userRepository->find($user->getId());
		if(empty($user->getUserAvatar()))
		{
			$userAvatar = new UserAvatar();
			$user->setUserAvatar($userAvatar);
		}

		$form = $this->createForm(ProfileType::class, $user);

		// ********************
		// POST
		// ********************
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			// Persist submission
			$em = $this->getDoctrine()->getManager();
			$em->persist($user);
			$em->flush();

			return $this->redirectToRoute('user_profile');
		}

		$this->data['form'] = $form->createView();

		return $this->render('common/profile/index.html.twig', $this->data);
	}

	/**
	 * @Route("/profile/password", name="user_profile_password")
	 */
	public function password(Request $request, UserPasswordEncoderInterface $passwordEncoder, UserRepository $userRepository)
	{

		$user = $this->security->getUser();

		// Get rid of serializazion issue => get user entity
		$user = $userRepository->find($user->getId());

		$form = $this->createForm(ProfilePasswordType::class, $user);

		// ********************
		// POST
		// ********************
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			// Encodes password
			$password = $passwordEncoder->encodePassword($user, $user->getPassword());
			$user->setPassword($password);

			// Persist submission
			$em = $this->getDoctrine()->getManager();
			$em->persist($user);
			$em->flush();

			return $this->redirectToRoute('user_profile');
		}

		$this->data['form'] = $form->createView();

		return $this->render('common/profile/index.html.twig', $this->data);
	}
}
