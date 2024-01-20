<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SousController extends AbstractController
{
    #[Route('/sous', name: 'app_sous')]
    public function index(): Response
    {
        return $this->render('sous/index.html.twig', [
            'controller_name' => 'SousController',
        ]);
    }
}
