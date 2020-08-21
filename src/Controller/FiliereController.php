<?php

namespace App\Controller;

use App\Entity\Filiere;
use App\Form\FiliereType;
use App\Repository\FiliereRepository;
use App\Utilities\Utility;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backend/filiere")
 */
class FiliereController extends AbstractController
{
    private $utility;

    public function __construct(Utility $utility)
    {
        $this->utility = $utility;
    }

    /**
     * @Route("/", name="backend_filiere_index", methods={"GET","POST"})
     */
    public function index(Request $request, FiliereRepository $filiereRepository): Response
    {
        $filiere = new Filiere();
        $form = $this->createForm(FiliereType::class, $filiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            // Slug
            $slug = $this->utility->slugify($filiere->getLibelle());
            $exist = $filiereRepository->findOneBy(['slug'=>$slug, 'institut'=>$filiere->getInstitut()]);
            if ($exist){
                $this->addFlash('error', "Oups!! Cette filière a déjà été enregistrée.");

                return $this->redirectToRoute('backend_filiere_index');
            }else{
                $filiere->setSlug($slug);
            }

            $entityManager->persist($filiere);
            $entityManager->flush();

            $this->addFlash('success', "Filière enregistrée avec succès");

            return $this->redirectToRoute('backend_filiere_index');
        }

        return $this->render('filiere/index.html.twig', [
            'filieres' => $filiereRepository->findBy([],['libelle'=>'ASC']),
            'filiere' => $filiere,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="backend_filiere_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $filiere = new Filiere();
        $form = $this->createForm(FiliereType::class, $filiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($filiere);
            $entityManager->flush();

            return $this->redirectToRoute('backend_filiere_index');
        }

        return $this->render('filiere/new.html.twig', [
            'filiere' => $filiere,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="backend_filiere_show", methods={"GET"})
     */
    public function show(Filiere $filiere): Response
    {
        return $this->render('filiere/show.html.twig', [
            'filiere' => $filiere,
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="backend_filiere_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Filiere $filiere, FiliereRepository $filiereRepository): Response
    {
        $form = $this->createForm(FiliereType::class, $filiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Slug
            $slug = $this->utility->slugify($filiere->getLibelle());
            $filiere->setSlug($slug);

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', "Filière a été modifiée avec succès");

            return $this->redirectToRoute('backend_filiere_index');
        }

        return $this->render('filiere/edit.html.twig', [
            'filieres' => $filiereRepository->findBy([],['libelle'=>'ASC']),
            'filiere' => $filiere,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="backend_filiere_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Filiere $filiere): Response
    {
        if ($this->isCsrfTokenValid('delete'.$filiere->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($filiere);
            $entityManager->flush();
        }

        return $this->redirectToRoute('backend_filiere_index');
    }
}
