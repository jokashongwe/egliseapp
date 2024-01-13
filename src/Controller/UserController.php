<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Departement;
use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Security\Core\Security;
use App\Entity\Agent;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\Menu;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class UserController extends AbstractController
{
    #[Route('/user/Creation_User', name: 'Creation_User')]
    public function index(
        UserPasswordHasherInterface $passwordHasher,
        NotifierInterface $notifier,
        ManagerRegistry $doctrine,
        Request $request,
        EntityManagerInterface $manager,
        Security $security
    ): Response {


        $users = $security->getUser();
        //$id_users = $users->getId();
        if (strtolower($request->getMethod()) == "get") {

            return $this->render('user/Creation_User.html.twig', []);
        }
        $user = new User();
        $email = $request->get('email');
        $motDePasse = $request->get('motDePasse');
        $profil = $request->get('profil');
        $confirme = $request->get('confirme');

        $VerificationUniqueUserneme = $doctrine->getRepository(User::class)->findBy([
            'username' => $email
        ]);
        if ($VerificationUniqueUserneme != null) {

            $notifier->send(new Notification("Erreur, Taper une autre adresse mail", ['browser']));

            return $this->redirectToRoute('Creation_User');
        }

        $roles = [$profil];

        $plaintextPassword = $motDePasse;

        if (

            $email != null && $motDePasse != null && $profil != null



        ) {


            $user->setUsername($email);
            $user->setRoles($roles);
            $user->setCreatedAt(new \DateTime());
            $user->setSupprimer(false);
            $user->setUserCreation(null);
            $user->setUserModif(null);
            $user->setDateModif(null);
            $user->confirme = $confirme;

            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);



            $manager->persist($user);
            $manager->flush();


            $notifier->send(new Notification("Félicitation, l'utilisateur  est crée avec succés", ['browser']));

            return $this->redirectToRoute('Creation_User');
        }


        return $this->render('user/Creation_User.html.twig');
    }
}
