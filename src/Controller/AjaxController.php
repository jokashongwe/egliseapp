<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Departement;
use App\Entity\SousDepartement;
use Doctrine\Persistence\ManagerRegistry;

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
}
