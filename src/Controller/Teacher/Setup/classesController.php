<?php

namespace App\Controller\Teacher\Setup;

use App\Entity\Classe;
use App\Form\Type\ClassesType;
use App\Repository\ClasseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/teacher/setup/classes")
 */
class classesController extends AbstractController
{
    /**
     * @Route("/", name="classes_index", methods={"GET"})
     */
    public function index(ClasseRepository $classesRepository): Response
    {
        return $this->render('teacher/classes/index.html.twig', [
            'classes' => $classesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="classes_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $class = new Classe();
        $form = $this->createForm(ClassesType::class, $class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($class);
            $entityManager->flush();

            return $this->redirectToRoute('classes_index');
        }

        return $this->render('teacher/classes/new.html.twig', [
            'class' => $class,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="classes_show", methods={"GET"})
     */
    public function show(Classe $class): Response
    {
        return $this->render('teacher/classes/show.html.twig', [
            'class' => $class,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="classes_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Classe $class): Response
    {
        $form = $this->createForm(ClassesType::class, $class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('classes_index');
        }

        return $this->render('teacher/classes/edit.html.twig', [
            'class' => $class,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="classes_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Classes $class): Response
    {
        if ($this->isCsrfTokenValid('delete'.$class->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($class);
            $entityManager->flush();
        }

        return $this->redirectToRoute('teacher/classes_index');
    }
}
