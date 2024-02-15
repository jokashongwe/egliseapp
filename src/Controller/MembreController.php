<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Fidel;
use App\Entity\SousDepartement;
use App\Entity\Departement;
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
    #[Route('/Membre/creation_fidel', name: 'identification_fidel')]
    public function index(
        NotifierInterface $notifier,
        ManagerRegistry $doctrine,
        Request $request,
        EntityManagerInterface $manager,
        Security $security
    ): Response {

        $users = $security->getUser();
        $id_users = $users->getId();

        $departements = $doctrine->getRepository(Departement::class)->findby([
            'supprimer' => false
        ]);
        $sousdepartements = $doctrine->getRepository(SousDepartement::class)->findby(
            [
                'supprimer' => false
            ]
        );

        if ($departements == null || $sousdepartements == null) {
            $notifier->send(new Notification("Erreur , vous devez d'abord créer le departement et le sous-departement", ['browser']));

            return $this->redirectToRoute('Partage');
        }

        if (strtolower($request->getMethod()) == "get") {

            return $this->render('membre/identification.html.twig', [
                'departements' => $departements
            ]);
        }




        /*  */

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


        $departement = $request->get('departement');
        $sous_departement = $request->get('sousDepartement');



        $Departement1 = $doctrine->getRepository(Departement::class)->find($departement);
        $sousDepartement1 = $doctrine->getRepository(SousDepartement::class)->findOneBy(['nom' => $sous_departement]);

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
            $fidel->setDatemodif(null);
            $fidel->setIdutilisateur($id_users);
            $fidel->setModifIdUtilisateur(null);
            $fidel->setDepartement($Departement1);
            $fidel->setSousdepartement($sousDepartement1);

            $fidel->setDateEnregistrement(new \DateTime());

            $manager->persist($fidel);
            $manager->flush();


            $notifier->send(new Notification("Félicitation, le fidel est enregistré avec 
            succès", ['browser']));

            return $this->redirectToRoute('identification_fidel');
        }

        return $this->render('membre/identification.html.twig', [
            'departements' => $departements
        ]);
    }

    #[Route('/Membre/recherche_fidel', name: 'recherche_fidel')]
    public function indeex(
        NotifierInterface $notifier,
        ManagerRegistry $doctrine,
        Request $request,
        EntityManagerInterface $manager,
        Security $security
    ): Response {

        $users = $security->getUser();
        $fidels = [];
        if (strtolower($request->getMethod()) == "get") {

            return $this->render('membre/recherche.html.twig', [
                'fidels' => $fidels
            ]);
        }
        $nom = $request->get('nom');
        if (strtolower($request->getMethod()) == "post") {
            $fidels = $doctrine->getRepository(Fidel::class)->findbyRecherche($nom);


            if (!$fidels && $fidels == null) {
                $notifier->send(new Notification("Erreur, le fidel recherché n'existe pas", ['browser']));
                return $this->redirectToRoute('recherche_fidel');
            }
        }
        return $this->render('membre/recherche.html.twig', [
            'fidels' => $fidels
        ]);
    }
    #[Route('/Membre/liste_fidel', name: 'liste_fidel')]
    public function indeeex(
        NotifierInterface $notifier,
        ManagerRegistry $doctrine,
        Request $request,
        EntityManagerInterface $manager,
        Security $security
    ): Response {



        $fidels = $doctrine->getRepository(Fidel::class)->findBy([
            'deces' => false,
            'supprimer' => false
        ]);


        if (!$fidels && $fidels == null) {
            $notifier->send(new Notification("Erreur, il existe aucun fidel enregistré", ['browser']));
            return $this->redirectToRoute('identification_fidel');
        }

        return $this->render('membre/liste.html.twig', [
            'fidels' => $fidels
        ]);
    }

    #[Route('/Membre/suppression_fidel', name: 'suppression_fidel')]
    public function indeeeex(
        NotifierInterface $notifier,
        ManagerRegistry $doctrine,
        Request $request,
        EntityManagerInterface $manager,
        Security $security
    ): Response {

        $users = $security->getUser();
        $fidels = [];
        if (strtolower($request->getMethod()) == "get") {

            return $this->render('membre/suppression.html.twig', [
                'fidels' => $fidels
            ]);
        }
        $nom = $request->get('nom');
        if (strtolower($request->getMethod()) == "post") {
            $fidels = $doctrine->getRepository(Fidel::class)->findbyRecherche($nom);

            if (!$fidels && $fidels == null) {
                $notifier->send(new Notification("Erreur, le fidel recherché n'existe pas", ['browser']));
                return $this->redirectToRoute('suppression_fidel');
            }
        }
        return $this->render('membre/suppression.html.twig', [
            'fidels' => $fidels
        ]);
    }


    #[Route('/Membre/suppression_fidelOK/{id}', name: 'suppression_fidelOk')]
    public function indeeeeex(
        $id,
        NotifierInterface $notifier,
        ManagerRegistry $doctrine,
        Request $request,
        EntityManagerInterface $manager,
        Security $security
    ): Response {
        $fidels = [];

        if ($id != null) {

            $fidel = $doctrine->getRepository(Fidel::class)->find($id);

            $fidel->setSupprimer(true);


            if (!$fidel && $fidel == null) {
                $notifier->send(new Notification("Erreur, le fidel recherché n'existe pas", ['browser']));
                return $this->redirectToRoute('suppression_fidel');
            }

            $fidel->setSupprimer(true);
            $manager->flush();
            $notifier->send(new Notification("Le fidel est supprimé  avec 
            succès", ['browser']));

            return $this->redirectToRoute('suppression_fidel');
        }
        return $this->render('membre/suppression.html.twig', [
            'fidels' => $fidels
        ]);
    }

    #[Route('/Membre/modification_fidel', name: 'modification_fidel')]
    public function indeeeeeex(
        NotifierInterface $notifier,
        ManagerRegistry $doctrine,
        Request $request,
        EntityManagerInterface $manager,
        Security $security
    ): Response {

        $users = $security->getUser();
        $fidels = [];
        if (strtolower($request->getMethod()) == "get") {

            return $this->render('membre/modification.html.twig', [
                'fidels' => $fidels
            ]);
        }
        $nom = $request->get('nom');
        if (strtolower($request->getMethod()) == "post") {
            $fidels = $doctrine->getRepository(Fidel::class)->findbyRecherche($nom);

            if (!$fidels && $fidels == null) {
                $notifier->send(new Notification("Erreur, le fidel recherché n'existe pas", ['browser']));
                return $this->redirectToRoute('modification_fidel');
            }
        }
        return $this->render('membre/modification.html.twig', [
            'fidels' => $fidels
        ]);
    }
    #[Route('/Membre/modification_fidelOK/{id}', name: 'modification_fidelOk')]
    public function indeeeeeeex(
        $id,
        NotifierInterface $notifier,
        ManagerRegistry $doctrine,
        Request $request,
        EntityManagerInterface $manager,
        Security $security
    ): Response {
        $fidels = [];
        $departements = $doctrine->getRepository(Departement::class)->findAll();
        $sousdepartements = $doctrine->getRepository(SousDepartement::class)->findAll();

        if ($departements == null || $sousdepartements == null) {
            $notifier->send(new Notification("Erreur , vous devez d'abord créer le departement et le sous-departement", ['browser']));

            return $this->redirectToRoute('Partage');
        }

        if ($id != null) {

            $fidel = $doctrine->getRepository(Fidel::class)->find($id);


            if (!$fidel && $fidel == null) {
                $notifier->send(new Notification("Erreur, le fidel recherché n'existe pas", ['browser']));
                return $this->redirectToRoute('modification_fidel');
            }
        }
        return $this->render('membre/modification_fidelOK.html.twig', [
            'fidel' => $fidel,
            'departements' => $departements
        ]);
    }

    #[Route('/Membre/modification_fidelOKOK', name: 'modification_fidelOkOk')]
    public function indeeeeeeeeex(

        NotifierInterface $notifier,
        ManagerRegistry $doctrine,
        Request $request,
        EntityManagerInterface $manager,
        Security $security
    ): Response {


        $fidels = [];

        $users = $security->getUser();

        $id_users = $users->getId();

        $departements = $doctrine->getRepository(Departement::class)->findAll();
        $sousdepartements = $doctrine->getRepository(SousDepartement::class)->findAll();

        if ($departements == null || $sousdepartements == null) {
            $notifier->send(new Notification("Erreur , vous devez d'abord créer le departement et le sous-departement", ['browser']));

            return $this->redirectToRoute('Partage');
        }


        $id = $request->get('id');
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


        $departement = $request->get('departement');
        $sous_departement = $request->get('sousDepartement');



        $Departement1 = $doctrine->getRepository(Departement::class)->find($departement);
        $sousDepartement1 = $doctrine->getRepository(SousDepartement::class)->findOneBy(['nom' => $sous_departement]);

        $dateNai  = date_create_from_format("Y-m-d", $date_naissance);
        $dateCon  = date_create_from_format("Y-m-d", $date_conversion);
        $dateBapt = date_create_from_format("Y-m-d", $date_bapteme);



        $fidel = $doctrine->getRepository(Fidel::class)->find($id);
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
            $fidel->setDatemodif(new \DateTime());
            //
            $fidel->setModifIdUtilisateur($id_users);
            $fidel->setDepartement($Departement1);
            $fidel->setSousdepartement($sousDepartement1);
            //

            $manager->persist($fidel);
            $manager->flush();


            $notifier->send(new Notification("Félicitation,l'opération a reussie avec 
            succès", ['browser']));

            return $this->redirectToRoute('modification_fidel');
        }

        return $this->render('membre/modification.html.twig', [
            'fidels' => $fidels
        ]);
    }
}
