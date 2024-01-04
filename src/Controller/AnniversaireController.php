<?php

namespace App\Controller;

use App\Entity\Fidel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Monolog\Formatter\NormalizerFormatter;
use PHPUnit\Framework\Constraint\IsFalse;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\Translation\TranslatorInterface;

class AnniversaireController extends AbstractController
{
    #[Route('/anniversaire/today', name: 'anniversaire_today')]
    public function index(
        NotifierInterface $notifier,
        ManagerRegistry $doctrine,
        Request $request,
        EntityManagerInterface $manager,
        Security $security
    ): Response {

        $birthday = [];
        $age = [];

        $dateActuelle = new \DateTime();

        $fidels = $doctrine->getRepository(Fidel::class)->findBy([], ['nom' => 'ASC']);


        foreach ($fidels as $key) {
            $dateFromDatabase = $key->getDateNaissance();
            if ($dateFromDatabase->format('md') == $dateActuelle->format('md')) {
                $birthday[] = $key;
            }
        }



        return $this->render('anniversaire/AnniversaireToday.html.twig', [
            'fidels' => $birthday
        ]);
    }
    #[Route('/anniversaire/Recherche_Jour', name: 'anniversaire_Recherche_Jour')]
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

        $fidels = $doctrine->getRepository(Fidel::class)->findBy([], ['nom' => 'ASC']);


        foreach ($fidels as $key) {
            $dateFromDatabase = $key->getDateNaissance();
            if ($dateFromDatabase->format('md') == $dateActuelle->format('md')) {
                $birthday[] = $key;
            }
        }

        if (strtolower($request->getMethod()) == "post") {

            $debut = $request->get("debut");


            if (empty($debut)) {


                return $this->redirectToRoute('anniversaire_Recherche_Jour');
            }

            if (!empty($debut)) {
                $debut = date_create_from_format("Y-m-d", $debut);
            } else {
                $debut = "1950-01-01";
                $debut = date_create_from_format("Y-m-d", $debut);
            }

            $birthday = [];

            $fidels = $doctrine->getRepository(Fidel::class)->findBy([], ['nom' => 'ASC']);


            foreach ($fidels as $key) {
                $dateFromDatabase = $key->getDateNaissance();
                if ($dateFromDatabase->format('md') == $debut->format('md')) {
                    $birthday[] = $key;
                }
            }
        }


        return $this->render('anniversaire/RechercheAnniversaireJour.html.twig', [
            'fidels' => $birthday,
            'debut' => $debut
        ]);
    }

    #[Route('/anniversaire/Recherche_Mois', name: 'anniversaire_Recherche_Mois')]
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


                return $this->redirectToRoute('anniversaire_Recherche_Mois');
            }

            if (!empty($debut)) {
                $debut = date_create_from_format("Y-m-d", $debut);
            } else {
                $debut = "1950-01-01";
                $debut = date_create_from_format("Y-m-d", $debut);
            }



            $birthday = [];




            $fidels = $doctrine->getRepository(Fidel::class)->findBy([], ['nom' => 'ASC']);


            foreach ($fidels as $key) {
                $dateFromDatabase = $key->getDateNaissance();
                if ($dateFromDatabase->format('m') == $debut->format('m')) {
                    $birthday[] = $key;
                }
            }
            $moisEnLettres = $translator->trans($debut->format('F'), [], 'messages', 'fr');
        }



        return $this->render('anniversaire/RechercheAnniversaireMois.html.twig', [
            'fidels' => $birthday,
            'debut' => $moisEnLettres,
            //   'debutt' => $debut->format('Y-m-d')
        ]);
    }
}
