<?php

namespace App\Controller;

use App\Entity\Scolarite;
use App\Form\ScolariteType;
use App\Repository\AnneeRepository;
use App\Repository\ScolariteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backend/scolarite")
 */
class ScolariteController extends AbstractController
{
    private $anneerepository;

    public function __construct(AnneeRepository $anneeRepository)
    {
        $this->anneerepository = $anneeRepository;
    }

    /**
     * @Route("/", name="backend_scolarite_index", methods={"GET","POST"})
     */
    public function index(Request $request, ScolariteRepository $scolariteRepository): Response
    {
        $scolarite = new Scolarite();
        $form = $this->createForm(ScolariteType::class, $scolarite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Affectation de l'année academique
            $annee = $this->anneerepository->findOneBy([],['id'=>'DESC']);
            $scolarite->setAnnee($annee);

            // verification de la non existence de la filiere et de la classe concernée
            $verif = $scolariteRepository->findOneBy(['annee'=>$annee, 'filiere'=>$scolarite->getFiliere(), 'classe'=>$scolarite->getClasse()]);
            if ($verif){
                $this->addFlash('error',"La scolarité concernant cette classe a déjà été enregistrée.");
                return $this->redirectToRoute('backend_scolarite_index');
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($scolarite);
            $entityManager->flush();

            $this->addFlash('success', "La scolarité enregistrée avec succès!");

            return $this->redirectToRoute('backend_scolarite_index');
        }

        return $this->render('scolarite/index.html.twig', [
            'scolarites' => $scolariteRepository->findBy([],['classe'=>"ASC", 'filiere'=>"ASC", "annee"=>"DESC"]),
            'scolarite' => $scolarite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="backend_scolarite_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $scolarite = new Scolarite();
        $form = $this->createForm(ScolariteType::class, $scolarite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($scolarite);
            $entityManager->flush();

            return $this->redirectToRoute('backend_scolarite_index');
        }

        return $this->render('scolarite/new.html.twig', [
            'scolarite' => $scolarite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="backend_scolarite_show", methods={"GET"})
     */
    public function show(Scolarite $scolarite): Response
    {
        return $this->render('scolarite/show.html.twig', [
            'scolarite' => $scolarite,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="backend_scolarite_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Scolarite $scolarite, ScolariteRepository $scolariteRepository): Response
    {
        $form = $this->createForm(ScolariteType::class, $scolarite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', "Scolarité modifiée avec succès");

            return $this->redirectToRoute('backend_scolarite_index');
        }

        return $this->render('scolarite/edit.html.twig', [
            'scolarites' => $scolariteRepository->findBy([],['classe'=>"ASC", 'filiere'=>"ASC", "annee"=>"DESC"]),
            'scolarite' => $scolarite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="backend_scolarite_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Scolarite $scolarite): Response
    {
        if ($this->isCsrfTokenValid('delete'.$scolarite->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($scolarite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('backend_scolarite_index');
    }
}
