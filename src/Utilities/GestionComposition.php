<?php


namespace App\Utilities;


use App\Entity\CompositionTest;
use App\Repository\CompositionTestRepository;
use App\Repository\InscriptionRepository;
use App\Repository\TestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Flex\ComposerRepository;

class GestionComposition
{
    private $compositionRepository;
    private $testRepository;
    private $inscriptionRepository;
    private $entityManager;

    public function __construct(CompositionTestRepository $compositionRepository, TestRepository $testRepository, InscriptionRepository $inscriptionRepository, EntityManagerInterface $entityManager)
    {
        $this->testRepository = $testRepository;
        $this->inscriptionRepository = $inscriptionRepository;
        $this->compositionRepository = $compositionRepository;
        $this->entityManager = $entityManager;
    }

    public function affectation($candidat)
    {
        $test = $this->testRepository->findOneBy([],['id'=>'DESC']);

        //gestion de la date
        setlocale(LC_ALL, 'fr_FR.UTF8');
        $jour = strftime("%A");

        // Test de la date d'inscription
        //$date_debut_test = date('Y-d-m', strtotime($test->getDateDebut())) ; dd($test->getDateDebut());
        if ($test->getDateDebut() >= date('Y-m-d')){
            $date = $test->getDateDebut();
            $date_du_jour = date('Y-m-d', strtotime('-3 days', strtotime(date($date))));
        }else{
            $date_du_jour = date('Y-m-d');
        }

        // Tant que jour n'est pas trouver continuer a rechercher la date
        $date_composition = false;
        $n = 2;
        while ($date_composition === false)
        {
            $n = $n+1;
            $trois_jours_plutard = date('Y-m-d', strtotime('+'.$n.' days', strtotime(date($date_du_jour))));
            $jour_probable = strftime("%A", strtotime($trois_jours_plutard));

            // Verifier si le jour est désigné jour de compo alors rechercher si quota est atteint
            $mon_jour = $this->verifJour($jour_probable);
            if ($mon_jour === true){
                //rechercher le nombre de composition programmé pour la date trouvée
                $nombre_compo = $this->compositionRepository->nombre($trois_jours_plutard);
                if ($nombre_compo < $test->getNombre()){
                    $compositionTest = new CompositionTest();
                    $compositionTest->setDate($trois_jours_plutard);
                    $compositionTest->setTest($test);
                    $compositionTest->setCandidat($candidat);
                    $this->entityManager->persist($compositionTest);
                    $this->entityManager->flush();

                    $date_composition = true;
                }
            }
        }
        $resultat = strftime("%A %d %B %Y", strtotime($trois_jours_plutard));
        return $resultat;

    }

    /**
     * Vérification du jour
     *
     * @param $jour
     * @return bool|null
     */
    protected function verifJour($jour)
    {
        $test = $this->testRepository->findOneBy([],['id'=>"DESC"]);
        switch ($jour)
        {
            case "lundi":
                $resultat = $test->getLundi();
                break;
            case "mardi":
                $resultat = $test->getMardi();
                break;
            case "mercredi":
                $resultat = $test->getMercredi();
                break;
            case "jeudi":
                $resultat = $test->getJeudi();
                break;
            case "vendredi":
                $resultat = $test->getVendredi();
                break;
            case "samedi":
                $resultat = $test->getSamedi();
                break;
            default:
                $resultat = $test->getDimanche();
        }

        return $resultat;
    }
}