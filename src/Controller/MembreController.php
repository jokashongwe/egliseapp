<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Ecole;
use App\Entity\Fidel;;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Monolog\Formatter\NormalizerFormatter;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Security\Core\Security;

class MembreController extends AbstractController
{
    #[Route('/membre/creation_fidel', name: 'identification_fidel')]
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

            return $this->render('membre/identification.html.twig', []);
        }






        $nom = $request->get('nom');
        $postnom = $request->get('postnom');
        $prenom = $request->get('prenom');
        $sexe = $request->get('sexe');
        $date_naissance = $request->get('date_naissance');
        $lieu_naissance = $request->get('lieu_naissance');
        $profession = $request->get('profession');
        $date_conversion = $request->get('date_conversion');
        $date_bapteme = $request->get('date_bapteme');
        $phone = $request->get('phone');
        $etat_civil = $request->get('etat_civil');
        $categorie = $request->get('categorie');
        $observation = $request->get('observation');

        $avenue = $request->get('avenue');
        $Numero_adresse = $request->get('Numero_adresse');
        $Quartier = $request->get('Quartier');
        $commune = $request->get('commune');
        $ville = $request->get('ville');
        $province = $request->get('province');





        $dateNai  = date_create_from_format("Y-m-d", $date_naissance);
        $dateCon  = date_create_from_format("Y-m-d", $date_conversion);
        $dateBapt = date_create_from_format("Y-m-d", $date_bapteme);






        $fidel = new Fidel();
        if (

            $nom != null && $postnom != null &&
            $prenom != null && $sexe != null &&
            $profession != null && $date_naissance  != null &&
            $categorie != null && $date_conversion != null &&
            $date_bapteme != null && $phone != null
            && $etat_civil != null &&  $observation != null
            && $categorie != null  &&   $avenue != null
            && $Numero_adresse != null && $Quartier != null
            && $commune != null && $ville != null && $lieu_naissance != null && $province != null



        ) {
            $fidel->setNom($nom);
            $fidel->setPostnom($postnom);
            $fidel->setPrenom($prenom);
            $fidel->setSexe($sexe);
            $fidel->setDateNaissance($dateNai);
            $fidel->setLieunaissance($lieu_naissance);
            $fidel->setProfession($profession);
            $fidel->setDateConversion($dateCon);
            $fidel->setDateBapteme($dateBapt);
            $fidel->setNumeroPhone($phone);
            $fidel->setEtatcivil($etat_civil);
            $fidel->setCategorie($categorie);
            $fidel->setObservation($observation);
            $fidel->setAvenue($avenue);
            $fidel->setNumeroadresse($Numero_adresse);
            $fidel->setQuartier($Quartier);
            $fidel->setCommune($commune);
            $fidel->setVille($ville);
            $fidel->setProvince($province);
            $fidel->setSupprimer(false);
            $fidel->setDeces(false);
            // $fidel->setIdutilisateur($id_users);
            $fidel->setDateEnregistrement(new \DateTime());

            $manager->persist($fidel);
            $manager->flush();


            $notifier->send(new Notification("Félicitation, le fidel est enregistré avec succés", ['browser']));

            return $this->redirectToRoute('identification_fidel');
        }

        return $this->render('membre/identification.html.twig');
    }
}
