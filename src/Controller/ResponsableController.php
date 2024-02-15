<?php

namespace App\Controller;

use App\Entity\Departement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Fidel;
use App\Entity\SousDepartement;
use App\Entity\Responsable;
use App\Repository\ResponsableRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Security\Core\Security;

class ResponsableController extends AbstractController
{
    #[Route('/responsable/Enregistrement_responsable', name: 'Enregistrement_responsable')]
    public function index(
        NotifierInterface $notifier,
        ManagerRegistry $doctrine,
        Request $request,
        EntityManagerInterface $manager,
        Security $security
    ): Response {

        $departement = $doctrine->getRepository(Departement::class)->findby([
            'supprimer' => false
        ]);
        $sousdepartement = $doctrine->getRepository(SousDepartement::class)->findby([
            'supprimer' => false
        ]);

        if (strtolower($request->getMethod()) == "get") {

            return $this->render(
                'responsable/index.html.twig',
                [
                    'departements' => $departement,
                    'sousdepartements' => $sousdepartement
                ]
            );
        }
        $nom = $request->get('nom');
        $departementid = $request->get('departement');

        // dd($departementid);

        $sousdepartementid = $request->get('sousdepartement');

        $reponsable = new Responsable();



        $departementd = $doctrine->getRepository(Departement::class)->find($departementid);

        // dd($departementd);

        $sousdepartements = $doctrine->getRepository(SousDepartement::class)->find($sousdepartementid);
        $fidel = $doctrine->getRepository(Fidel::class)->find($nom);



        if ($fidel == null) {

            $notifier->send(new Notification("Erreur ,  le fidel n'existe pas ", ['browser']));
            return $this->render(
                'responsable/index.html.twig',
                [
                    'departements' => $departement,
                    'sousdepartements' => $sousdepartement
                ]
            );
        }


        if ($departementd == null && $sousdepartements == null) {

            $notifier->send(new Notification("Erreur ,  le departement et le sous-departement sont null Choisissez au moins une rubrique ", ['browser']));
            return $this->render(
                'responsable/index.html.twig',
                [
                    'departements' => $departement,
                    'sousdepartements' => $sousdepartement
                ]
            );
        }


        if ($departementd == null) {

            $notifier->send(new Notification("Erreur ,  le departement ne peut pas etre null ", ['browser']));
            return $this->render(
                'responsable/index.html.twig',
                [
                    'departements' => $departement,
                    'sousdepartements' => $sousdepartement
                ]
            );
        }


        if ($departementd != null && $sousdepartements != null) {

            $iddepart = $departementd->getId();

            $idsous = $sousdepartements->getDepartement()->getId();

            //   dd($iddepart, $idsous);
            if ($iddepart != $idsous) {



                $notifier->send(new Notification("Erreur ,  le departement et le sous-departement ne corespondent pas  ", ['browser']));
                return $this->render(
                    'responsable/index.html.twig',
                    [
                        'departements' => $departement,
                        'sousdepartements' => $sousdepartement
                    ]
                );
            }
        }


        $reponsable->setFidel($fidel);
        $reponsable->setDepartement($departementd);
        $reponsable->setSousdepartement($sousdepartements);

        $manager->persist($reponsable);
        $manager->flush();
        $notifier->send(new Notification("succès", ['browser']));
        return $this->render(
            'responsable/index.html.twig',
            [
                'departements' => $departement,
                'sousdepartements' => $sousdepartement
            ]
        );
    }

    #[Route('/responsable/Liste_responsable', name: 'Liste_responsable')]
    public function inddeeex(
        NotifierInterface $notifier,
        ManagerRegistry $doctrine,
        Request $request,
        EntityManagerInterface $manager,
        Security $security
    ): Response {

        $responsables = $doctrine->getRepository(Responsable::class)->findAll();

        return $this->render('responsable/Liste_Departement.html.twig', [
            'responsables' => $responsables
        ]);
    }


    #[Route('/responsable/Modifier_responsable', name: 'Modifier_responsable')]
    public function inddeeeex(
        NotifierInterface $notifier,
        ManagerRegistry $doctrine,
        Request $request,
        EntityManagerInterface $manager,
        Security $security
    ): Response {

        $responsables = $doctrine->getRepository(Responsable::class)->findAll();

        return $this->render('responsable/Modifier_Departement.html.twig', [
            'responsables' => $responsables
        ]);
    }


    #[Route('/responsable/Modifier_responsableOK/{id}', name: 'Modifier_responsableOk')]
    public function inddeeeeex(
        $id,
        NotifierInterface $notifier,
        ManagerRegistry $doctrine,
        Request $request,
        EntityManagerInterface $manager,
        Security $security
    ): Response {

        $departements = $doctrine->getRepository(Departement::class)->findby([
            'supprimer' => false
        ]);
        $sousdepartements = $doctrine->getRepository(SousDepartement::class)->findby([
            'supprimer' => false
        ]);

        $responsable = $doctrine->getRepository(Responsable::class)->find($id);

        return $this->render('responsable/Modifier_DepartementOk.html.twig', [
            'responsables' => $responsable,
            'departements' => $departements,
            'sousdepartements' => $sousdepartements
        ]);
    }

    #[Route('/responsable/Modifier_responsableOKOK', name: 'Modifier_responsableOkOK')]
    public function inddeeeeeex(

        NotifierInterface $notifier,
        ManagerRegistry $doctrine,
        Request $request,
        EntityManagerInterface $manager,
        Security $security
    ): Response {
        $rresponsables = $doctrine->getRepository(Responsable::class)->findAll();
        $departement = $doctrine->getRepository(Departement::class)->findby([
            'supprimer' => false
        ]);
        $sousdepartement = $doctrine->getRepository(SousDepartement::class)->findby([
            'supprimer' => false
        ]);

        if (strtolower($request->getMethod()) == "get") {

            return $this->render(
                'responsable/Modifier_Departement.html.twig',
                [
                    'departements' => $departement,
                    'sousdepartements' => $sousdepartement,
                    'responsables' => $rresponsables
                ]
            );
        }
        $nom = $request->get('nom');
        $departementid = $request->get('departement');

        $iddd = $request->get('id');



        $sousdepartementid = $request->get('sousdepartement');

        $reponsable = $doctrine->getRepository(Responsable::class)->find($iddd);;



        $departementd = $doctrine->getRepository(Departement::class)->find($departementid);



        $sousdepartements = $doctrine->getRepository(SousDepartement::class)->find($sousdepartementid);
        $fidel = $doctrine->getRepository(Fidel::class)->find($nom);



        if ($fidel == null) {

            $notifier->send(new Notification("Erreur ,  le fidel n'existe pas ", ['browser']));
            return $this->redirectToRoute('Modifier_responsable');
        }


        if ($departementd == null && $sousdepartements == null) {

            $notifier->send(new Notification("Erreur ,  le departement et le sous-departement sont null Choisissez au moins une rubrique ", ['browser']));
            return $this->redirectToRoute('Modifier_responsable');
        }


        if ($departementd == null) {

            $notifier->send(new Notification("Erreur ,  le departement ne peut pas etre null ", ['browser']));
            return $this->redirectToRoute('Modifier_responsable');
        }


        if ($departementd != null && $sousdepartements != null) {

            $iddepart = $departementd->getId();

            $idsous = $sousdepartements->getDepartement()->getId();

            //   dd($iddepart, $idsous);
            if ($iddepart != $idsous) {



                $notifier->send(new Notification("Erreur ,  le departement et le sous-departement ne corespondent pas  ", ['browser']));
                return $this->redirectToRoute('Modifier_responsable');
            }
        }


        $reponsable->setFidel($fidel);
        $reponsable->setDepartement($departementd);
        $reponsable->setSousdepartement($sousdepartements);

        $manager->persist($reponsable);
        $manager->flush();
        $notifier->send(new Notification("succès", ['browser']));


        return $this->redirectToRoute('Modifier_responsable');
    }
}
