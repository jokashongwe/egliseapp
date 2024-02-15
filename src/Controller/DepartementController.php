<?php

namespace App\Controller;

use App\Entity\Departement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Security\Core\Security;

class DepartementController extends AbstractController
{
    #[Route('/departement/Creation_Departement', name: 'Creation_Departement')]
    public function index(
        NotifierInterface $notifier,
        ManagerRegistry $doctrine,
        Request $request,
        EntityManagerInterface $manager,
        Security $security
    ): Response {



        $users = $security->getUser();
        //$id_users = $users->getId();
        if (strtolower($request->getMethod()) == "get") {

            return $this->render('departement/index.html.twig', []);
        }

        $nom = $request->get('nom');
        $responsable = $request->get('responsable');
        $adjoint = $request->get('adjoint');


        $departement = new Departement();
        if (

            $nom != null



        ) {
            $departement->setNom($nom);
            $departement->setResponsable(null);
            $departement->setAdjoint(null);
            $departement->setSupprimer(false);



            $manager->persist($departement);
            $manager->flush();


            $notifier->send(new Notification("Félicitation, le département est crée avec succés", ['browser']));

            return $this->redirectToRoute('Creation_Departement');
        }
        return $this->render('departement/index.html.twig');
    }

    #[Route('/departement/Modification_Departement', name: 'Modification_Departement')]
    public function indeex(
        NotifierInterface $notifier,
        ManagerRegistry $doctrine,
        Request $request,
        EntityManagerInterface $manager,
        Security $security
    ): Response {

        $departement = $doctrine->getRepository(Departement::class)->findBy([
            'supprimer' => false
        ]);

        return $this->render('departement/modification.html.twig', [
            'departement' => $departement
        ]);
    }

    #[Route('/departement/Modification_Departementok/{id}', name: 'Modification_Departementok')]
    public function indeeex(
        $id,
        NotifierInterface $notifier,
        ManagerRegistry $doctrine,
        Request $request,
        EntityManagerInterface $manager,
        Security $security
    ): Response {

        $departement = $doctrine->getRepository(Departement::class)->find($id);

        return $this->render('departement/modificationOK.html.twig', [
            'departement' => $departement
        ]);
    }

    #[Route('/departement/Liste_Departement', name: 'Liste_Departement')]
    public function inddeeex(
        NotifierInterface $notifier,
        ManagerRegistry $doctrine,
        Request $request,
        EntityManagerInterface $manager,
        Security $security
    ): Response {

        $departement = $doctrine->getRepository(Departement::class)->findBy([
            'supprimer' => false
        ]);

        return $this->render('departement/Liste_Departement.html.twig', [
            'departement' => $departement
        ]);
    }
}
