<?php

namespace App\Controller\Teacher\Setup;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SkillRepository;

class skillsController extends AbstractController
{
    /**
     * @Route("/teacher/setup/skills", name="teacher_skills")
     */
    public function index(SkillRepository $skillRepository)
    {
			$skills = $skillRepository->findAll();


        return $this->render('teacher/skills/index.html.twig', compact('skills'));
    }
}
