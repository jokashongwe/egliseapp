<?php

namespace App\Controller;

use App\Entity\Fidel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Security\Core\Security;

class PartageController extends AbstractController
{
    #[Route('/partage', name: 'Partage')]
    public function index(
        ManagerRegistry $doctrine,
        Request $request,
        ManagerRegistry $managerRegistry,

        NotifierInterface $notifier,
        EntityManagerInterface $manager,
        Security $security
    ): Response {






        $nMembre = $managerRegistry->getRepository(Fidel::class)->NbrMembre();


        // $nEleveAbandons = $managerRegistry->getRepository(Eleve::class)->countEleveAbandons($anneeScolaire->getannee_scolaire());

        // $nAgent = $managerRegistry->getRepository(Agent::class)->countAgent();

        // //dd($nAgent);

        $nMembreParSexe = $managerRegistry->getRepository(Fidel::class)->countMembreBySexe();
        $cResultat = $managerRegistry->getRepository(Fidel::class)->countBycategorie();
        $categorieLabel = [];
        $categorieValeur = [];
        foreach ($cResultat as $resultat) {
            $categorieLabel[] = $resultat['categorie'];
            $categorieValeur[] = $resultat['nbr'];
        }
        // $sectionsLabel = [];
        // $sectionsValeur = [];
        // foreach ($cResultat as $resultat) {
        //     $sectionsLabel[] = $resultat['section'];
        //     $sectionsValeur[] = $resultat['nbr'];
        // }
        // $eleves = [];
        // if (strtolower($request->getMethod()) == 'post') {
        //     $n = $request->get('cherche');


        //     $eleves = $doctrine->getRepository(Eleve::class)->findBy1Value($n, $anneeScolaire->getannee_scolaire());
        //     /// je vais gerer le coté empty du vide ... une condition gerant le vide
        //     if (!$eleves && $n != null) {
        //         $this->addFlash('danger', 'L\'ELEVE N\'EXISTE PAS!');
        //     }
        // }

        return $this->render("partage/index.html.twig", [
            'eleves' => [],
            'nMembre' => $nMembre,
            'nMembreParSexe' => $nMembreParSexe,
            'categorieLabel' => $categorieLabel,
            'categorieValeur' => $categorieValeur,
            'nAgent' => [],
            'EleveAbandons' => []
        ]);
    }
}
