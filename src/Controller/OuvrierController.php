<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Fidel;
use App\Entity\Departement;
use App\Repository\FidelRepository;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Security\Core\Security;

class OuvrierController extends AbstractController
{
    #[Route('/ouvrier', name: 'ouvrier_statistique')]
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

            $fidels = $managerRegistry->getRepository(Fidel::class)->createQueryBuilder('f')
                ->where('f.deces = :deces')
                ->andWhere('f.supprimer = :supprimer')
                ->andWhere('f.nom = :nom')
                ->andWhere('f.departement > 0')
                ->setParameter('deces', 0)
                ->setParameter('supprimer', 0)
                ->setParameter('nom', $nom)
                ->getQuery()
                ->getResult();


            if (!$fidels && $fidels == null) {
                $notifier->send(new Notification("Erreur, le fidel recherché n'existe pas", ['browser']));
                return $this->redirectToRoute('Partage');
            }
        }

        $fidelsTotal = $managerRegistry->getRepository(Fidel::class)->createQueryBuilder('f')
            ->where('f.deces = :deces')
            ->andWhere('f.supprimer = :supprimer')
            ->andWhere('f.departement > 0')
            ->setParameter('deces', 0)
            ->setParameter('supprimer', 0)
            ->getQuery()
            ->getResult();


        $MT  = count($fidelsTotal);

        $nombreFilles = 0;
        $nombreGarcons = 0;

        foreach ($fidelsTotal as $fidel) {
            // Supposons que $fidel->getDepartement()->getGenre() retourne le genre du département
            //$genreDepartement = $fidel->getDepartement()->getGenre();

            // Supposez que vous avez un moyen de déterminer le genre de chaque fidel (par exemple, une méthode getGenre() dans l'entité Fidel)
            $genreFidel = $fidel->getSexe();

            // Incrémentez le nombre de filles ou de garçons en fonction du genre
            if ($genreFidel === 'Féminin') {
                $nombreFilles++;
            } elseif ($genreFidel === 'Masculin') {
                $nombreGarcons++;
            }
        }

        $nMembre = [];
        // $managerRegistry->getRepository(Fidel::class)->NbrMembreOuvrier();

        $nMembreParSexe = $managerRegistry->getRepository(Fidel::class)->countMembreBySexeOuvrier();
        $cResultat = $managerRegistry->getRepository(Fidel::class)->countBycategorieOuvrier();
        $categorieLabel = [];
        $categorieValeur = [];
        foreach ($cResultat as $resultat) {
            $categorieLabel[] = $resultat['categorie'];
            $categorieValeur[] = $resultat['nbr'];
        }

        return $this->render('ouvrier/index.html.twig', [
            'eleves' => [],
            'nMembre' => $nMembre,
            'nMembreParSexe' => $nMembreParSexe,
            'categorieLabel' => $categorieLabel,
            'categorieValeur' => $categorieValeur,
            'fidels' => $fidels,
            'total' => $MT,
            'nombreFilles'    => $nombreFilles,
            'nombreGarcons'    =>   $nombreGarcons
        ]);
    }
}
