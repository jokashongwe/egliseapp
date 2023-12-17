<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PartageController extends AbstractController
{
    #[Route('/partage', name: 'app_partage')]
    public function index(): Response
    {
        return $this->render('partage/index.html.twig', [
            'controller_name' => 'PartageController',
        ]);
    }
}
