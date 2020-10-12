<?php

namespace App\Controller\Teacher\Results;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class gradebookController extends AbstractController
{
    /**
     * @Route("/teacher/results/gradebook", name="teacher_results_gradebook")
     */
    public function index()
    {
        return $this->render('teacher/results/gradebook/index.html.twig', [
            'controller_name' => 'gradebookController',
        ]);
    }
}
