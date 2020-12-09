<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function Registration(): Response
    {
        return $this->render('security/registration.html.twig');
    }

    /**
    * @Route("/connexion", name="security_login")
    */
    public function Login(): Response
    {
        return $this->render('security/login.html.twig');
    }

    /**
    * @Route("/deconnexion",name="security_logout")
    *
    */
    public function Logout()
    {
        // Cette métnode ne retourne rien, il nous suffit d'avoir une route pour se deconnecter
    }
}
