<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnniversaireController extends AbstractController
{
    #[Route('/anniversaire', name: 'app_anniversaire')]
    public function index(): Response
    {
        return $this->render('anniversaire/index.html.twig', [
            'controller_name' => 'AnniversaireController',
        ]);
    }
}
