<?php

namespace App\Controller\Teacher\Results;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class simplifiedController extends AbstractController
{
    /**
     * @Route("/teacher/results/simplified", name="teacher_results_simplified")
     */
    public function index()
    {
        return $this->render('teacher/results/simplified/index.html.twig', [
            'controller_name' => 'simplifiedController',
        ]);
    }
}
