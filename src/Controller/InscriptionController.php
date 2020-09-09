<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Form\InscriptionType;
use App\Repository\InscriptionRepository;
use App\Utilities\GestionComposition;
use App\Utilities\GestionMail;
use App\Utilities\GestionMedia;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/inscription")
 */
class InscriptionController extends AbstractController
{
    private $gestionMedia;
    private $gestionMail;
    private $gestionComposition;

    public function __construct(GestionMedia $gestionMedia, GestionMail $gestionMail, GestionComposition  $gestionComposition)
    {
        $this->gestionMedia = $gestionMedia;
        $this->gestionMail = $gestionMail;
        $this->gestionComposition = $gestionComposition;
    }

    /**
     * @Route("/", name="inscription_index", methods={"GET"})
     */
    public function index(InscriptionRepository $inscriptionRepository): Response
    {
        return $this->render('inscription/index.html.twig', [
            'inscriptions' => $inscriptionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="inscription_new", methods={"GET","POST"})
     */
    public function new(Request $request, InscriptionRepository $inscriptionRepository): Response
    {
        $user = $this->getUser();
        $inscription = new Inscription();
        $form = $this->createForm(InscriptionType::class, $inscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            // Verification de non existence de l'user
            $verif = $inscriptionRepository->findOneBy(['user'=>$user]);
            if ($verif){
                $this->addFlash('error', "Vous êtes déjà inscrit(e)! Si vous pensez que c'est une erreur, veuillez contacter les administrateurs.");
                return $this->redirectToRoute('inscription_new');
            }

            $reference = time();
            //Verification d'existence
            $exist = $inscriptionRepository->findOneBy([
                'nom'=>$inscription->getNom(),
                'prenoms'=> $inscription->getPrenoms(),
                'dateNaissance'=> $inscription->getDateNaissance(),
                'lieuNaissance' => $inscription->getLieuNaissance(),
                'contact' => $inscription->getContact(),
            ]);
            if ($exist){
                $this->addFlash('error', "Oups!!! Vous êtes déjà inscrit.");
                return $this->redirectToRoute('inscription_new');
            }

            // Gestion des fichiers
            $mediaFile = $form->get('fileIdentite')->getData();
            $mediaBac = $form->get('baccalaureat')->getData();
            $mediaDiplome = $form->get('fileDiplome')->getData();

            // Traitement du fichier s'il a été telechargé
            if ($mediaFile){
                $media = $this->gestionMedia->upload($mediaFile, 'identite');

                $inscription->setFileIdentite($media);
            }

            // Traitement du baccalaureat
            if ($mediaBac){
                $bac = $this->gestionMedia->upload($mediaBac, 'bac');

                $inscription->setBaccalaureat($bac);
            }

            // Traitement du dernier diplome
            if ($mediaDiplome){
                $diplome = $this->gestionMedia->upload($mediaDiplome, 'diplome');

                $inscription->setFileDiplome($diplome);
            }

            $inscription->setReference($reference);
            $inscription->setUser($user);

            $entityManager->persist($inscription);
            $entityManager->flush();

            $this->addFlash('succes', "Votre pré-inscription a bien été enregistrée. Vous serez notifié(e) après analyse de votre dossier.");
            $this->gestionMail->notificationInscriptionTest('PRE-INSCRIPTION ENREGISTREE AVEC SUCCES', $inscription);

            return $this->redirectToRoute('inscription_show',['reference'=>$inscription->getReference()]);
        }

        // Verification de non existence de l'user
        $verif = $inscriptionRepository->findOneBy(['user'=>$user]);
        if ($verif){
            return $this->redirectToRoute('inscription_show',['reference'=>$verif->getReference()]);
        }

        return $this->render('inscription/new.html.twig', [
            'inscription' => $inscription,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{reference}", name="inscription_show", methods={"GET"})
     */
    public function show(Inscription $inscription): Response
    {
        $format_jour = '%#d';
        $jour = strftime("%A $format_jour %B %Y", strtotime($inscription->getDateNaissance())); //dd($jour);
        $user = $this->getUser();
        if ($this->getUser() !== $inscription->getUser()){
            //throw $this->createNotFoundException('Attention vous ne pouvez pas acceder à ce profil');
            throw  new \Exception("Attention vous ne pouvez pas acceder à ce profil");
        }
        return $this->render('inscription/show.html.twig', [
            'inscription' => $inscription,
        ]);
    }

    /**
     * @Route("/{reference}/edit", name="inscription_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Inscription $inscription): Response
    {
        $form = $this->createForm(InscriptionType::class, $inscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('succes', "Votre profil a été modifié avec succès");

            return $this->redirectToRoute('inscription_show', ['reference'=>$inscription->getReference()]);
        }

        return $this->render('inscription/edit.html.twig', [
            'inscription' => $inscription,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="inscription_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Inscription $inscription): Response
    {
        if ($this->isCsrfTokenValid('delete'.$inscription->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($inscription);
            $entityManager->flush();
        }

        return $this->redirectToRoute('inscription_index');
    }
}
