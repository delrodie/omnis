<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Form\ClasseType;
use App\Repository\ClasseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backend/classe")
 */
class ClasseController extends AbstractController
{
    /**
     * @Route("/", name="backend_classe_index", methods={"GET","POST"})
     */
    public function index(Request $request, ClasseRepository $classeRepository): Response
    {
        $classe = new Classe();
        $form = $this->createForm(ClasseType::class, $classe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($classe);
            $entityManager->flush();

            return $this->redirectToRoute('backend_classe_index');
        }

        return $this->render('classe/index.html.twig', [
            'classes' => $classeRepository->findAll(),
            'classe' => $classe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="backend_classe_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $classe = new Classe();
        $form = $this->createForm(ClasseType::class, $classe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($classe);
            $entityManager->flush();

            return $this->redirectToRoute('backend_classe_index');
        }

        return $this->render('classe/new.html.twig', [
            'classe' => $classe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="backend_classe_show", methods={"GET"})
     */
    public function show(Classe $classe): Response
    {
        return $this->render('classe/show.html.twig', [
            'classe' => $classe,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="backend_classe_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Classe $classe, ClasseRepository $classeRepository): Response
    {
        $form = $this->createForm(ClasseType::class, $classe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_classe_index');
        }

        return $this->render('classe/edit.html.twig', [
            'classes' => $classeRepository->findAll(),
            'classe' => $classe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="backend_classe_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Classe $classe): Response
    {
        if ($this->isCsrfTokenValid('delete'.$classe->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($classe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('backend_classe_index');
    }
}