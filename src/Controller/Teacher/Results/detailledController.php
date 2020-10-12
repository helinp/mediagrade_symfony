<?php

namespace App\Controller\Teacher\Results;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class detailledController extends AbstractController
{
    /**
     * @Route("/teacher/results/detailled", name="teacher_results_detailled")
     */
    public function index()
    {
        return $this->render('teacher/results/detailled/index.html.twig', [
            'controller_name' => 'detailledController',
        ]);
    }
}
