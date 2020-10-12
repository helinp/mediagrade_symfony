<?php

namespace App\Controller\Teacher\Projects;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class assessController extends AbstractController
{
    /**
     * @Route("/teacher/projects/assess", name="teacher_projects_assess")
     */
    public function index()
    {
        return $this->render('teacher/projects/assess/index.html.twig', [
            'controller_name' => 'assessController',
        ]);
    }
}
