<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndController extends AbstractController
{
    /**
     * @Route("/ind", name="ind")
     */
    public function index(): Response
    {
        return $this->render('ind/index.html.twig', [
            'controller_name' => 'IndController',
        ]);
    }
}
