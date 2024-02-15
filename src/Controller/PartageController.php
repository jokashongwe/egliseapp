<?php

namespace App\Controller;

use App\Entity\Fidel;
use App\Entity\Departement;
use App\Repository\FidelRepository;
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
    #[Route('/Partage', name: 'Partage')]
    public function index(
        ManagerRegistry $doctrine,
        Request $request,
        ManagerRegistry $managerRegistry,

        NotifierInterface $notifier,
        EntityManagerInterface $manager,
        Security $security,
        FidelRepository $fidelRepository
    ): Response {
        $fidels = [];


        $nom = $request->get('nom');
        if (strtolower($request->getMethod()) == "post") {
            $fidels = $doctrine->getRepository(Fidel::class)->findbyRecherche($nom);


            if (!$fidels && $fidels == null) {
                $notifier->send(new Notification("Erreur, le fidel recherché n'existe pas", ['browser']));
                return $this->redirectToRoute('Partage');
            }
        }
        $fidelsTotal = $fidelRepository->findByValueStatistiquetotal();

        $MTM = $fidelsTotal[0];
        $MT = $MTM['total'];



        $nMembre = $managerRegistry->getRepository(Fidel::class)->NbrMembre();

        $nMembreParSexe = $managerRegistry->getRepository(Fidel::class)->countMembreBySexe();
        $cResultat = $managerRegistry->getRepository(Fidel::class)->countBycategorie();
        $categorieLabel = [];
        $categorieValeur = [];
        foreach ($cResultat as $resultat) {
            $categorieLabel[] = $resultat['categorie'];
            $categorieValeur[] = $resultat['nbr'];
        }

        return $this->render("partage/index.html.twig", [
            'eleves' => [],
            'nMembre' => $nMembre,
            'nMembreParSexe' => $nMembreParSexe,
            'categorieLabel' => $categorieLabel,
            'categorieValeur' => $categorieValeur,
            'nAgent' => [],
            'EleveAbandons' => [],
            'fidels' => $fidels,
            'total' => $MT
        ]);
    }
}
