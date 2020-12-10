<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EsController extends AbstractController
{
    /**
     * @Route("/es", name="es")
     */
    public function index(): Response
    {
        return $this->render('es/index.html.twig', [
            'controller_name' => 'EsController',
        ]);
    }
}
