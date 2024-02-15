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

    #[Route('/sous_departement/Modification_SousDepartement', name: 'Modification_SousDepartement')]
    public function indeex(
        NotifierInterface $notifier,
        ManagerRegistry $doctrine,
        Request $request,
        EntityManagerInterface $manager,
        Security $security
    ): Response {

        $sousdepartement = $doctrine->getRepository(SousDepartement::class)->findBy([
            'supprimer' => false
        ]);

        return $this->render('sous_departement/modification.html.twig', [
            'sousdepartement' => $sousdepartement
        ]);
    }

    #[Route('/sous_departement/Modification_SousDepartementok/{id}', name: 'Modification_SousDepartementok')]
    public function indeeex(
        $id,
        NotifierInterface $notifier,
        ManagerRegistry $doctrine,
        Request $request,
        EntityManagerInterface $manager,
        Security $security
    ): Response {

        $sousdepartement = $doctrine->getRepository(SousDepartement::class)->find($id);
        $departements = $doctrine->getRepository(Departement::class)->findBy([
            'supprimer' => false
        ]);
        return $this->render('sous_departement/modificationOK.html.twig', [
            'sousdepartement' => $sousdepartement,
            'departements' => $departements
        ]);
    }


    #[Route('/sous_departement/modifier_sous_departement', name: 'modifier_sous_departement')]

    public function modifierSousDepartement(
        NotifierInterface $notifier,
        Request $request,

        ManagerRegistry $doctrine,
        // EntityManagerInterface $manager,
    ) {

        $ids = $request->get('ids');


        // Récupérer le sous-département à partir de l'ID
        $sousDepartement = $doctrine->getRepository(SousDepartement::class)->findOneBy([
            'id' => $ids
        ]);

        if (!$sousDepartement) {
            throw $this->createNotFoundException('Sous-département non trouvé pour l\'ID ');
        }

        // Récupérer les données du formulaire envoyé en AJAX
        $data = json_decode($request->getContent(), true);

        // Mettre à jour les attributs du sous-département
        $sousDepartement->setNom($request->get('nom'));
        $sousDepartement->setResponsable($request->get('responsable'));

        // Gérer la relation ManyToOne avec le département
        $departementId = $request->get('departementId');
        $departement = $doctrine->getRepository(Departement::class)->find($departementId);
        $sousDepartement->setDepartement($departement);

        // Enregistrer les modifications en base de données
        $entityManager = $doctrine->getManager();
        $entityManager->persist($sousDepartement);
        $entityManager->flush();

        $sousdepartementss = $doctrine->getRepository(SousDepartement::class)->findBy([
            'supprimer' => false
        ]);
        $notifier->send(new Notification("Félicitation, le sous-département est modifié avec succés", ['browser']));
        return $this->redirectToRoute('Modification_SousDepartement');
    }

    #[Route('/sous_departement/Liste_SousDepartement', name: 'Liste_SousDepartement')]
    public function indeeeex(
        NotifierInterface $notifier,
        ManagerRegistry $doctrine,
        Request $request,
        EntityManagerInterface $manager,
        Security $security
    ): Response {

        $sousdepartement = $doctrine->getRepository(SousDepartement::class)->findBy([
            'supprimer' => false
        ]);

        return $this->render('sous_departement/Liste.html.twig', [
            'sousdepartement' => $sousdepartement
        ]);
    }
}
