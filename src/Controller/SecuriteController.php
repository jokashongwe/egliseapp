<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Security\Core\Security;

class SecuriteController extends AbstractController
{







    #[Route('/logout', name: 'app_logout', methods: 'GET')]
    public function Deconnexion()
    {
    }


    #[Route('/', name: 'Connexion')]
    public function Connexion(NotifierInterface $notifier, AuthenticationUtils $authenticationUtils, ManagerRegistry $doctrine, Request $request, EntityManagerInterface $manager): Response
    {

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();


        if ($error) {
            $this->addFlash('danger', 'Votre login est incorrect!');
        }


        return $this->render('securite/Connexion.html.twig', [
            //  'formArticle'  => $form->createView(),
            'last_username' => $lastUsername,
            'error' => "",
        ]);
    }
}
