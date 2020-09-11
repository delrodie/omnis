<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Form\EtudiantType;
use App\Repository\EtudiantRepository;
use App\Utilities\GestionMail;
use App\Utilities\GestionMedia;
use Cocur\Slugify\Slugify;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/etudiant")
 */
class EtudiantController extends AbstractController
{
    private $gestionMedia;
    private $gestionMail;

    public function __construct(GestionMail $gestionMail, GestionMedia $gestionMedia)
    {
        $this->gestionMail= $gestionMail;
        $this->gestionMedia = $gestionMedia;
    }

    /**
     * @Route("/", name="etudiant_index", methods={"GET"})
     */
    public function index(EtudiantRepository $etudiantRepository): Response
    {
        return $this->render('etudiant/index.html.twig', [
            'etudiants' => $etudiantRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="etudiant_new", methods={"GET","POST"})
     */
    public function new(Request $request, EtudiantRepository $etudiantRepository): Response
    {
        $user = $this->getUser();
        $etudiant = new Etudiant();
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            // Gestion du slug
            $reference = time();
            $slugify = new Slugify();
            $slug = $slugify->slugify($etudiant->getNom().'-'.$etudiant->getPrenoms().'-'.$reference);

            // Verification de la non existence de l'etudiant dans la table
            $verif = $etudiantRepository->findOneBy(['user'=>$user]);
            if ($verif){
                $this->addFlash('error', "Votre email est déjà associé à un compte étudiant. Si vous pensez que cette une erreur, veuillez contacter l'administrattion ");
                $this->redirectToRoute('etudiant_new');
            }

            // Verification d'existence
            $exists = $etudiantRepository->findOneBy([
                'nom' => $etudiant->getNom(),
                'prenoms'=>$etudiant->getPrenoms(),
                'dateNaiss' => $etudiant->getDateNaiss(),
                'lieuNaiss' => $etudiant->getLieuNaiss(),
                'contact' => $etudiant->getContact(),
            ]);
            if ($exists){
                $this->addFlash('error', "Oups!! Vous êtes déjà identifier dans le système. Si vous pensez que c'est une erreur, veuillez contacter l'administration");
                return $this->redirectToRoute('etudiant_new');
            }

            // Gestion des fichiers
            $mediaFile = $form->get('photo')->getData();

            // Traitement du fichier s'il a été telechargé
            if ($mediaFile){
                $media = $this->gestionMedia->upload($mediaFile, 'photo');

                $etudiant->setPhoto($media);
            }

            $etudiant->setUser($user);
            $etudiant->setSlug($slug);
            //$etudiant->setMatricule($reference);

            $entityManager->persist($etudiant);
            $entityManager->flush();

            $this->addFlash('success', "Votre identification a été effectuée avec succès.");
            $this->gestionMail->notificationIdentificationEtudiant($etudiant);

            return $this->redirectToRoute('etudiant_show',['slug'=>$etudiant->getSlug()]);
        }

        return $this->render('etudiant/new.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="etudiant_show", methods={"GET"})
     */
    public function show(Etudiant $etudiant): Response
    {
        return $this->render('etudiant/show.html.twig', [
            'etudiant' => $etudiant,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="etudiant_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Etudiant $etudiant): Response
    {
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('etudiant_index');
        }

        return $this->render('etudiant/edit.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="etudiant_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Etudiant $etudiant): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etudiant->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($etudiant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('etudiant_index');
    }
}
