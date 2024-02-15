<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SMSController extends AbstractController
{
    #[Route('/Sms/EnvoiSmsIndividuel', name: 'EnvoiSmsIndividuel')]
    public function index(): Response
    {
        return $this->render('sms/index.html.twig');
    }
}
