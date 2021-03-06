<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Repository\InscriptionRepository;
use App\Utilities\GestionComposition;
use App\Utilities\GestionMail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BackendInscriptionController
 * @Route("/backend/inscription")
 */
class BackendInscriptionController extends AbstractController
{
    private $inscriptionRepository;
    private $gestionMail;
    private $gestionComposition;

    public function __construct(InscriptionRepository $inscriptionRepository, GestionMail $gestionMail, GestionComposition $gestionComposition)
    {
        $this->inscriptionRepository =$inscriptionRepository;
        $this->gestionMail = $gestionMail;
        $this->gestionComposition = $gestionComposition;
    }
    /**
     * @Route("/", name="backend_inscription_index")
     */
    public function index()
    {
        return $this->render('backend_inscription/index.html.twig', [
            'inscriptions' => $this->inscriptionRepository->findBy([],['reference'=>'DESC']),
        ]);
    }

    /**
     * @Route("/{reference}", name="backend_inscription_show", methods={"GET"})
     */
    public function show(Inscription $inscription)
    {
        return $this->render('backend_inscription/show.html.twig',[
            'inscription'=> $inscription
        ]);
    }

    /**
     * @Route("/{reference}/edit", name="backend_inscription_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Inscription $inscription)
    {
        $validation = $request->get('inscription_validation');
        if ($validation === $inscription->getReference()){
            $inscription->setValid(true);
            $this->getDoctrine()->getManager()->flush();

            // Generation de la date de test
            $date_composition = $this->gestionComposition->affectation($inscription);

            // Envoi de mail d'approbation de demande
            $this->gestionMail->notificationInscriptionTestValidation("VALIDATION DE LA PRE-INSCRIPTION",$inscription, $date_composition);

            // Calendrier de passage

            $this->addFlash('success', "Demande de test approuvée");
        }else{
            $this->addFlash('error', "Echec de la validation, veuillez reprendre");
        }

        return $this->render('backend_inscription/show.html.twig',[
            'inscription'=> $inscription
        ]);
    }
}
