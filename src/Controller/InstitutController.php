<?php

namespace App\Controller;

use App\Entity\Institut;
use App\Form\InstitutType;
use App\Repository\InstitutRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backend/institut")
 */
class InstitutController extends AbstractController
{
    /**
     * @Route("/", name="backend_institut_index", methods={"GET","POST"})
     */
    public function index(Request $request, InstitutRepository $institutRepository): Response
    {
        $institut = new Institut();
        $form = $this->createForm(InstitutType::class, $institut);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            // Verification d'existence
            $exist  = $institutRepository->findOneBy(['sigle'=>$institut->getSigle()]);
            if ($exist){
                $this->addFlash('error', "Cet institut a déjà été enregistré dans le système!");
                return $this->redirectToRoute('backend_institut_index');
            }
            $entityManager->persist($institut);
            $entityManager->flush();

            $this->addFlash('success', "L'institut a été enregistré avec succès");

            return $this->redirectToRoute('backend_institut_index');
        }

        return $this->render('institut/index.html.twig', [
            'instituts' => $institutRepository->findBy([],['sigle'=>'ASC']),
            'institut' => $institut,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="backend_institut_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $institut = new Institut();
        $form = $this->createForm(InstitutType::class, $institut);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($institut);
            $entityManager->flush();

            return $this->redirectToRoute('backend_institut_index');
        }

        return $this->render('institut/new.html.twig', [
            'institut' => $institut,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="backend_institut_show", methods={"GET"})
     */
    public function show(Institut $institut): Response
    {
        return $this->render('institut/show.html.twig', [
            'institut' => $institut,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="backend_institut_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Institut $institut, InstitutRepository $institutRepository): Response
    {
        $form = $this->createForm(InstitutType::class, $institut);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', "L'institut a été modifié avec succès");

            return $this->redirectToRoute('backend_institut_index');
        }

        return $this->render('institut/edit.html.twig', [
            'instituts' => $institutRepository->findBy([],['sigle'=>'ASC']),
            'institut' => $institut,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="backend_institut_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Institut $institut): Response
    {
        if ($this->isCsrfTokenValid('delete'.$institut->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($institut);
            $entityManager->flush();
        }

        return $this->redirectToRoute('backend_institut_index');
    }
}
