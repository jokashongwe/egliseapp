<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Departement;
use App\Entity\SousDepartement;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Security\Core\Security;


class SousDepartementController extends AbstractController
{

    #[Route('/sousdepartement/Creation_Sousdepartement', name: 'Creation_Sousdepartement')]
    public function index(
        NotifierInterface $notifier,
        ManagerRegistry $doctrine,
        Request $request,
        EntityManagerInterface $manager,
        Security $security
    ): Response {

        $users = $security->getUser();

        $departements = $doctrine->getRepository(Departement::class)->findAll();


        if (strtolower($request->getMethod()) == "get") {

            return $this->render('sous_departement/index.html.twig', [
                'departement' => $departements
            ]);
        }


        $nom = $request->get('nom');
        $responsable = $request->get('responsable');
        $adjoint = $request->get('adjoint');
        $departement = $request->get('departement');

        $sousdepartement = new SousDepartement();
        if (

            $nom != null && $departement != null



        ) {
            $departement1 = $doctrine->getRepository(Departement::class)->find($departement);

            $sousdepartement->setNom($nom);
            $sousdepartement->setResponsable(null);
            $sousdepartement->setAdjoint(null);
            $sousdepartement->setDepartement($departement1);

            $sousdepartement->setSupprimer(false);



            $manager->persist($sousdepartement);
            $manager->flush();


            $notifier->send(new Notification("Félicitation, le sous-département est crée avec succés", ['browser']));

            return $this->redirectToRoute('Creation_Sousdepartement');
        }
        return $this->render('sous_departement/index.html.twig', [
            'departement' => $departements
        ]);
    }
}
