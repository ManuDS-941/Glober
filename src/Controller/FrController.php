<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrController extends AbstractController
{
    /**
     * @Route("/fr", name="fr")
     */
    public function index(): Response
    {
        return $this->render('fr/index.html.twig', [
            'controller_name' => 'FrController',
        ]);
    }

    /**
     * @Route("/show_fr_ville", name="show_fr_ville")
     */
    public function showVille(): Response
    {
        return $this->render('fr/show_fr_ville.html.twig', [
            'controller_name' => 'FrController',
        ]);
    }



}

