<?php

namespace App\Controller;

use App\Entity\CompositionTest;
use App\Form\CompositionTestType;
use App\Repository\CompositionTestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backend/composition/test")
 */
class CompositionTestController extends AbstractController
{
    /**
     * @Route("/", name="composition_test_index", methods={"GET"})
     */
    public function index(CompositionTestRepository $compositionTestRepository): Response
    {
        return $this->render('composition_test/index.html.twig', [
            'composition_tests' => $compositionTestRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="composition_test_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $compositionTest = new CompositionTest();
        $form = $this->createForm(CompositionTestType::class, $compositionTest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($compositionTest);
            $entityManager->flush();

            return $this->redirectToRoute('composition_test_index');
        }

        return $this->render('composition_test/new.html.twig', [
            'composition_test' => $compositionTest,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="composition_test_show", methods={"GET"})
     */
    public function show(CompositionTest $compositionTest): Response
    {
        return $this->render('composition_test/show.html.twig', [
            'composition_test' => $compositionTest,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="composition_test_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CompositionTest $compositionTest): Response
    {
        $form = $this->createForm(CompositionTestType::class, $compositionTest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('composition_test_index');
        }

        return $this->render('composition_test/edit.html.twig', [
            'composition_test' => $compositionTest,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="composition_test_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CompositionTest $compositionTest): Response
    {
        if ($this->isCsrfTokenValid('delete'.$compositionTest->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($compositionTest);
            $entityManager->flush();
        }

        return $this->redirectToRoute('composition_test_index');
    }
}
