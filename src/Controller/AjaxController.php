<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Departement;
use App\Entity\Fidel;
use App\Entity\SousDepartement;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Security\Core\Security;

class AjaxController extends AbstractController
{
    /**
     * @Route("/get-sous-departements/{id}", name="get_sous_departements", methods={"GET"})
     */
    public function getSousDepartements(ManagerRegistry $doctrine, Request $request, Departement $departement)
    {
        $sousDepartements = $doctrine->getRepository(SousDepartement::class)->findBy(['departement' => $departement]);

        $sousDepartementArray = [];
        foreach ($sousDepartements as $sousDepartement) {
            $sousDepartementArray[] = $sousDepartement->getNom(); // Adapter selon votre structure d'entité
        }

        return new JsonResponse($sousDepartementArray);
    }
    /**
     * @Route("/search", name="search")
     */
    public function search(Request $request, ManagerRegistry $doctrine)
    {
        $searchTerm = $request->query->get('term');
        $results = $doctrine->getRepository(Fidel::class)->findBy([
            'numero_phone' => $searchTerm
        ]);

        $formattedResults = [];
        foreach ($results as $result) {
            $formattedResults[] = [
                'nom' => $result->getNom(),
                'postnom' => $result->getPostnom(),
                'prenom' => $result->getPrenom(),
                // Ajoutez d'autres champs selon vos besoins
            ];
        }

        return new JsonResponse($formattedResults);
    }
    /**
     * @Route("/searchRecherche", name="searchRecherche")
     */
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $searchTerm = $request->query->get('term');

        // Utilisez Doctrine pour récupérer les résultats depuis MySQL
        $results = $doctrine->getRepository(Fidel::class)->findBy([
            'nom' => $searchTerm,
            'supprimer' => false
        ]);

        // Convertissez les résultats en tableau pour la réponse JSON
        $formattedResults = [];
        foreach ($results as $result) {
            $formattedResults[] = [
                'nom' => $result->getNom(),
                'postnom' => $result->getPostnom(),
                'prenom' => $result->getPrenom(),
                'id' => $result->getId(),
                // Ajoutez d'autres champs selon vos besoins
            ];
        }

        return new JsonResponse($formattedResults);
    }

    /**
     * @Route("/modifier-departement/{id}", name="modifier_departement", methods={"POST"})
     */
    public function modifierDepartement(
        Request $request,
        Departement $departement,
        ManagerRegistry $doctrine,
        EntityManagerInterface $manager,
    ) {
        // Traiter la soumission du formulaire
        $nom = $request->request->get('nom');
        $responsable = $request->request->get('responsable');

        // Mettez à jour les attributs du département
        $departement->setNom($nom);
        $departement->setResponsable($responsable);

        // Enregistrez les modifications dans la base de données

        // $manager->persist($departement);
        //$manager->flush();
        $entityManager = $doctrine->getManager();
        $entityManager->flush();

        // Renvoyer une réponse JSON indiquant le succès
        return new JsonResponse(['success' => true]);
    }
    public function generatePdf(
        NotifierInterface $notifier,
        ManagerRegistry $doctrine,
        Request $request,
        EntityManagerInterface $manager,
        Security $security
    ): Response {

        $departement = $doctrine->getRepository(Departement::class)->findby([
            'supprimer' => false
        ]);
        // Contenu HTML du tableau
        $html = $this->renderView('impression/Liste_DepartementImpression.html.twig', [
            'departement' => $departement
        ]);

        // Configurez Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);

        // Créez une instance de Dompdf
        $dompdf = new Dompdf($options);

        // Chargez le contenu HTML dans Dompdf
        $dompdf->loadHtml($html);

        // Définir la taille du papier (A4 par défaut)
        $dompdf->setPaper('A4', 'portrait');

        // Rendre le PDF
        $dompdf->render();

        // Renvoyer le PDF en tant que réponse
        $response = new Response($dompdf->output());
        $response->headers->set('Content-Type', 'application/pdf');

        return $response;
    }
}
