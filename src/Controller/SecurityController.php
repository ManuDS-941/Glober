<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function Registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, AuthorizationCheckerInterface $authChecker): Response
    // Request $request : récupère les données du formulaire dans la variable $request
    // EntityManagerInterface : Permet de manipuler la BDD
    // UserPasswordEncoderInterface : Permet d'encoder un élément
    // AuthorizationCheckerInterface : Permet de maintenir la connexion
    {

        // SI l'internaute est connecté, il n'a rien a faire sur la route '/inscription', on le redirige vers la route '/accueil'
        if($authChecker->isGranted('ROLE_ADMIN'))
        {
            return $this->redirectToRoute('admin');
        }
        else if($authChecker->isGranted('ROLE_USER'))
        {
            return $this->redirectToRoute('accueil');
        }

        $user = new User; // Définit un nouvel User dans la variable $user

        dump($request); // On verifie les valeurs de saisie du formulaire


        $formInscription = $this->createForm(RegistrationType::class, $user, ['validation_groups' => ['registration']]); // On génère un formulaire dans la variable $formInscription à partir des données de RegistrationType, ces données seront stockés dans la variable $user avec les contraintes défini dans registration (ne pas oublier mettre a jour le fichier security.yaml)

        $formInscription->handleRequest($request); // On verifie les données si elles ont été bien remplies et envoyé dans les setters

        if($formInscription->isSubmitted() && $formInscription->isValid()) // si formulaire soumis et valide
        {
            $hash = $encoder->encodePassword($user, $user->getPassword()); // Encode le password(du getter password) de la variable $user // Pour que sa fonctionne il faut implementer User avec l'interface UserInterface et déclarer les 5 méthodes : getPAssword(), getUsername(), getSalt(), getRoles() et eraceCredentials()

            $user->setPassword($hash); // on envoie le mot de passe haché dans l'entité $user

            $user->setRoles(["ROLE_USER"]); // on définit un role ROLE_USER a chaque nouvelle inscription sur le blog

            $manager->persist($user); // On maintient l'envoie en BDD
            $manager->flush(); // On execute

            return $this->redirectToRoute('security_login'); // redirige vers la page connexion
        }

        return $this->render('security/registration.html.twig', [
            'formInscription' => $formInscription->createView()
        ]);
    }

    /**
    * @Route("/connexion", name="security_login")
    */
    public function Login(AuthenticationUtils $authenticationUtils, AuthorizationCheckerInterface $authChecker): Response
    {
        // SI l'internaute est connecté, il n'a rien a faire sur la route '/connexion', on le redirige vers la route '/admin'
        if($authChecker->isGranted('ROLE_ADMIN'))
        {
            return $this->redirectToRoute('admin');
        }
        else if($authChecker->isGranted('ROLE_USER'))
        {
            return $this->redirectToRoute('accueil');
        }

    // Récupération du message d'erreur en cas de mauvaise connexion
    $error = $authenticationUtils->getLastAuthenticationError();

    // Récupération du dernier username (email) saisi par l'internaute en cas d'erreur
    $lastUsername = $authenticationUtils->getLastUsername();



    return $this->render('security/login.html.twig', [
        'error' => $error,
        'last_username' => $lastUsername
    ]);
    }

    /**
    * @Route("/deconnexion", name="security_logout")
    *
    */
    public function Logout()
    {
        // Cette métnode ne retourne rien, il nous suffit d'avoir une route pour se deconnecter
    }
}
