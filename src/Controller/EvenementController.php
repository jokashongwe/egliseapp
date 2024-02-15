<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Fidel;
use App\Entity\SousDepartement;
use App\Entity\Departement;
use App\Entity\Evenement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Monolog\Formatter\NormalizerFormatter;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\Translation\TranslatorInterface;

class EvenementController extends AbstractController
{
    #[Route('/evenement/Creation_Evenement', name: 'Creation_Evenement')]
    public function index(
        NotifierInterface $notifier,
        ManagerRegistry $doctrine,
        Request $request,
        EntityManagerInterface $manager,
        Security $security
    ): Response {




        $users = $security->getUser();
        $id_users = $users->getId();


        $evenement = new Evenement();

        $titre = $request->get('titre');
        $date = $request->get('date');
        $observation = $request->get('observation');
        $date_  = date_create_from_format("Y-m-d", $date);
        //dd(111);

        if (strtolower($request->getMethod()) == "get") {

            return $this->render('evenement/index.html.twig');
        }


        if (

            $titre != null  && $date  != null &&
            $observation != null

        ) {

            $evenement->setTitre($titre);

            $evenement->setDate($date_);


            $evenement->setDescription($observation);

            $manager->persist($evenement);
            $manager->flush();


            $notifier->send(new Notification("Félicitation, l'événement est enregistré avec 
            succès", ['browser']));

            return $this->redirectToRoute('Creation_Evenement');
        }

        return $this->render('evenement/index.html.twig');
    }



    #[Route('/evenement/Modification_Evenement', name: 'Modification_Evenement')]
    public function indeex(
        NotifierInterface $notifier,
        ManagerRegistry $doctrine,
        Request $request,
        EntityManagerInterface $manager,
        Security $security
    ): Response {

        $evenements = $doctrine->getRepository(Evenement::class)->findAll();

        return $this->render(
            'evenement/Modification_Evenement.html.twig',
            [
                "evenements" => $evenements
            ]
        );
    }


    #[Route('/evenement/Modification_EvenementOk/{id}', name: 'Modification_EvenementOk')]
    public function indeeex(
        $id,
        NotifierInterface $notifier,
        ManagerRegistry $doctrine,
        Request $request,
        EntityManagerInterface $manager,
        Security $security
    ): Response {

        $evenements = $doctrine->getRepository(Evenement::class)->find($id);



        return $this->render(
            'evenement/Modification_EvenementOK.html.twig',
            [
                "evenements" => $evenements
            ]
        );
    }



    #[Route('/evenement/Modification_EvenementOKOK', name: 'Modification_EvenementOKOK')]
    public function indeeeex(
        NotifierInterface $notifier,
        ManagerRegistry $doctrine,
        Request $request,
        EntityManagerInterface $manager,
        Security $security
    ): Response {


        $users = $security->getUser();
        $id_users = $users->getId();
        $id = $request->get('id');

        $evenement = $doctrine->getRepository(Evenement::class)->find($id);

        $titre = $request->get('titre');
        $date = $request->get('date');


        $observation = $request->get('observation');
        $date_  = date_create_from_format("Y-m-d", $date);


        if (strtolower($request->getMethod()) == "get") {

            return $this->render('evenement/Modification_Evenement.html.twig');
        }


        if (

            $titre != null  && $date  != null &&
            $observation != null

        ) {

            $evenement->setTitre($titre);

            $evenement->setDate($date_);


            $evenement->setDescription($observation);

            $manager->persist($evenement);
            $manager->flush();


            $notifier->send(new Notification("Félicitation, l'événement est modifié avec 
            succès", ['browser']));

            return $this->redirectToRoute('Modification_Evenement');
        }

        return $this->render('evenement/Modification_Evenement.html.twig');
    }

    #[Route('/evenement/Choisir_ModeRechercheEvenement', name: 'Choisir_ModeRechercheEvenement')]
    public function indeeeeex(

        NotifierInterface $notifier,
        ManagerRegistry $doctrine,
        Request $request,
        EntityManagerInterface $manager,
        Security $security
    ): Response {



        return $this->render(
            'evenement/ChoisirRecherche.html.twig'
        );
    }


    #[Route('/evenement/RechercheEvenement_Jounaliere', name: 'RechercheEvenement_Jounaliere')]
    public function indeeeeeex(
        NotifierInterface $notifier,
        ManagerRegistry $doctrine,
        Request $request,
        EntityManagerInterface $manager,
        Security $security
    ): Response {

        $birthday = [];
        $age = [];

        $dateActuelle = new \DateTime();



        $evenements = $doctrine->getRepository(Evenement::class)->findBy([], ['Titre' => 'ASC']);


        foreach ($evenements as $key) {
            $dateFromDatabase = $key->getDate();
            if ($dateFromDatabase->format('md') == $dateActuelle->format('md')) {
                $birthday[] = $key;
            }
        }
        return $this->render(
            'evenement/RechercheEvenementJournaliere.html.twig',
            [
                'evenements' => $birthday
            ]
        );
    }
    #[Route('/anniversaire/RechercheEvenement_Jour', name: 'RechercheEvenement_Jour')]
    public function indexe(
        NotifierInterface $notifier,
        ManagerRegistry $doctrine,
        Request $request,
        EntityManagerInterface $manager,
        Security $security,
        ManagerRegistry $managerRegistry
    ): Response {
        $fidel = [];
        $birthday = [];
        $debut = null;

        $dateActuelle = new \DateTime();

        $evenements = $doctrine->getRepository(Evenement::class)->findBy([], ['Titre' => 'ASC']);


        foreach ($evenements as $key) {
            $dateFromDatabase = $key->getDate();
            if ($dateFromDatabase->format('md') == $dateActuelle->format('md')) {
                $birthday[] = $key;
            }
        }

        if (strtolower($request->getMethod()) == "post") {

            $debut = $request->get("debut");


            if (empty($debut)) {


                return $this->redirectToRoute('RechercheEvenement_Jour');
            }

            if (!empty($debut)) {
                $debut = date_create_from_format("Y-m-d", $debut);
            } else {
                $debut = "1950-01-01";
                $debut = date_create_from_format("Y-m-d", $debut);
            }

            $birthday = [];

            $evenements = $doctrine->getRepository(Evenement::class)->findBy([], ['Titre' => 'ASC']);


            foreach ($evenements as $key) {
                $dateFromDatabase = $key->getDate();
                if ($dateFromDatabase->format('md') == $debut->format('md')) {
                    $birthday[] = $key;
                }
            }
        }


        return $this->render('evenement/RechercheEvenement_Jour.html.twig', [
            'evenements' => $birthday,
            'debut' => $debut
        ]);
    }

    #[Route('/evenement/RechercheEvenement_Mois', name: 'RechercheEvenement_Mois')]
    public function indexee(
        NotifierInterface $notifier,
        ManagerRegistry $doctrine,
        Request $request,
        EntityManagerInterface $manager,
        Security $security,
        ManagerRegistry $managerRegistry,
        TranslatorInterface $translator
    ): Response {
        $fidel = [];
        $birthday = [];
        $debut = null;
        $dateActuelle = new \DateTime();

        $moisEnLettres = "";

        if (strtolower($request->getMethod()) == "post") {

            $debut = $request->get("debut");
            $fin = $request->get("fin");

            if (empty($debut)) {


                return $this->redirectToRoute('RechercheEvenement_Mois');
            }

            if (!empty($debut)) {
                $debut = date_create_from_format("Y-m-d", $debut);
            } else {
                $debut = "1950-01-01";
                $debut = date_create_from_format("Y-m-d", $debut);
            }



            $birthday = [];




            $evenements = $doctrine->getRepository(Evenement::class)->findBy([], ['Titre' => 'ASC']);


            foreach ($evenements as $key) {
                $dateFromDatabase = $key->getDate();
                if ($dateFromDatabase->format('m') == $debut->format('m')) {
                    $birthday[] = $key;
                }
            }
            $moisEnLettres = $translator->trans($debut->format('F'), [], 'messages', 'fr');
        }



        return $this->render('evenement/RechercheEvenement_Mois.html.twig', [
            'evenements' => $birthday,
            'debut' => $moisEnLettres,
            //   'debutt' => $debut->format('Y-m-d')
        ]);
    }
}
