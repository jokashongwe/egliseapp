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
use App\Entity\Fidel;
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
        $id_users = $users->getId();
        if (strtolower($request->getMethod()) == "get") {

            return $this->render('user/Creation_User.html.twig', []);
        }
        $user = new User();
        $email = $request->get('email');

        $motDePasse = $request->get('motDePasse');
        $profil = $request->get('profil');
        $confirme = $request->get('confirme');
        $id = $request->get('nom');

        $fidel = $doctrine->getRepository(Fidel::class)->find($id);

        $use = $doctrine->getRepository(User::class)->findOneBy([
            'fidel' => $id
        ]);

        if ($use != null) {

            $notifier->send(new Notification("Erreur, ce fidel a déjà un compte utilisateur", ['browser']));

            return $this->redirectToRoute('Creation_User');
        }

        if ($fidel == null) {

            $notifier->send(new Notification("Erreur, le fidel n'existe pas", ['browser']));

            return $this->redirectToRoute('Creation_User');
        }

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
            $user->setUserCreation($id_users);
            $user->setUserModif(null);
            $user->setDateModif(null);
            $user->setFidel($fidel);
            $user->confirme = $confirme;

            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);



            $manager->persist($user);
            $manager->flush();


            $notifier->send(new Notification("Félicitation, l'utilisateur  est crée avec 
            succès", ['browser']));

            return $this->redirectToRoute('Creation_User');
        }


        return $this->render('user/Creation_User.html.twig');
    }



    #[Route('/user/Modification_User', name: 'Modification_User')]
    public function indeex(
        UserPasswordHasherInterface $passwordHasher,
        NotifierInterface $notifier,
        ManagerRegistry $doctrine,
        Request $request,
        EntityManagerInterface $manager,
        Security $security
    ): Response {


        $users = $security->getUser();
        $id_users = $users->getId();
        if (strtolower($request->getMethod()) == "get") {

            return $this->render('user/Modification_User.html.twig', []);
        }
        $user = new User();
        $email = $request->get('email');
        $motDePasse = $request->get('motDePasse');
        $profil = $request->get('profil');
        $confirme = $request->get('confirme');
        $id = $request->get('nom');

        $fidel = $doctrine->getRepository(Fidel::class)->find($id);

        $use = $doctrine->getRepository(User::class)->findOneBy([
            'fidel' => $id
        ]);

        //dd($use);

        if ($use == null) {

            $notifier->send(new Notification("Erreur, ce fidel n'a de compte utilisateur", ['browser']));

            return $this->redirectToRoute('Modification_User');
        }
        if ($fidel == null) {

            $notifier->send(new Notification("Erreur, le fidel n'existe pas", ['browser']));

            return $this->redirectToRoute('Modification_User');
        }

        $VerificationUniqueUserneme = $doctrine->getRepository(User::class)->findBy([
            'username' => $email
        ]);
        if ($VerificationUniqueUserneme != null) {

            $notifier->send(new Notification("Erreur, Taper une autre adresse mail", ['browser']));

            return $this->redirectToRoute('Modification_User');
        }

        $roles = [$profil];

        $plaintextPassword = $motDePasse;

        if (

            $email != null && $motDePasse != null && $profil != null



        ) {


            $use->setUsername($email);
            $use->setRoles($roles);
            $use->setCreatedAt(new \DateTime());
            $use->setSupprimer(false);
            $use->setUserCreation($id_users);
            $use->setUserModif(null);
            $use->setDateModif(null);
            $use->setFidel($fidel);
            $use->confirme = $confirme;

            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $use->setPassword($hashedPassword);



            $manager->persist($use);
            $manager->flush();


            $notifier->send(new Notification("Félicitation, l'utilisateur  est modifié avec 
            succès", ['browser']));

            return $this->redirectToRoute('Modification_User');
        }


        return $this->render('user/Modification_User.html.twig');
    }

    #[Route('/user/Supprimer_User', name: 'Supprimer_User')]
    public function indeeex(
        UserPasswordHasherInterface $passwordHasher,
        NotifierInterface $notifier,
        ManagerRegistry $doctrine,
        Request $request,
        EntityManagerInterface $manager,
        Security $security
    ): Response {


        $users = $security->getUser();
        $id_users = $users->getId();
        if (strtolower($request->getMethod()) == "get") {

            return $this->render('user/Supprimer_User.html.twig', []);
        }

        $id = $request->get('nom');

        $fidel = $doctrine->getRepository(Fidel::class)->find($id);

        $use = $doctrine->getRepository(User::class)->findOneBy([
            'fidel' => $id
        ]);


        if ($use == null) {

            $notifier->send(new Notification("Erreur, ce fidel n'a de compte utilisateur", ['browser']));

            return $this->redirectToRoute('Supprimer_User');
        }
        if ($fidel == null) {

            $notifier->send(new Notification("Erreur, le fidel n'existe pas", ['browser']));

            return $this->redirectToRoute('Supprimer_User');
        }

        $use->setSupprimer(true);

        $manager->persist($use);
        $manager->flush();


        $notifier->send(new Notification("l'utilisateur est supprimé avec 
            succès", ['browser']));

        return $this->redirectToRoute('Supprimer_User');



        return $this->render('user/Supprimer_User.html.twig');
    }
    #[Route('/user/Liste_user', name: 'Liste_user')]
    public function indeeeex(
        NotifierInterface $notifier,
        ManagerRegistry $doctrine,
        Request $request,
        EntityManagerInterface $manager,
        Security $security
    ): Response {

        $user = $doctrine->getRepository(User::class)->findBy([
            'supprimer' => false
        ]);

        return $this->render('user/Liste.html.twig', [
            'users' => $user
        ]);
    }
}
