<?php

namespace App\Controller;

use App\Entity\Ville;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PTController extends AbstractController
{
    /**
     * @Route("/pt", name="pt")
     */
    public function index(VilleRepository $repo, EntityManagerInterface $manager): Response
    {

        // Selectionne les données de Ville dans la BDD
        $tableau = $manager->getClassMetadata(Ville::class)->getFieldNames();

        dump($tableau);

        // Selectionne les villes dans la BDD
        $ville = $repo->findAll();

        dump($ville);

        return $this->render('pt/index.html.twig', [
            'controller_name' => 'PTController',
            'ville' => $ville,
            'tableau' => $tableau
        ]);
    }

    /**
     * @Route("/pt/show/{id}", name="portugal")
     */
    public function show(): Response
    {
        return $this->render('pt/show.html.twig', [
            'controller_name' => 'PTController',
        ]);
    }




}
