<?php

namespace App\Controller;

use App\Entity\Pays;
use App\Entity\Ville;
use App\Entity\Category;
use App\Repository\PaysRepository;
use App\Repository\VilleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FrController extends AbstractController
{
    /**
     * @Route("/fr", name="fr")
     */
    public function index(VilleRepository $repo,  EntityManagerInterface $manager): Response
    {
        // Selectionne les données de Ville dans la BDD
        $colonnes = $manager->getClassMetadata(Ville::class)->getFieldNames();
        
        // Selectionne les villes dans la BDD
        $villesFr = $repo->findAll();

        dump($villesFr);

        //Permet l'affichage
        return $this->render('fr/index_fr.html.twig', [
            'controller_name' => 'FrController',
            'colonnes' => $colonnes,
            'ville' => $villesFr
        ]);
    }

    /**
     * @Route("/fr/show_fr_ville/{id}", name="show_fr_ville")
     */
    public function showVille(Ville $ville, CategoryRepository $repo, VilleRepository $repo2, EntityManagerInterface $manager): Response
    {
        // Selectionne les données de catégory dans la BDD
        $colonnes = $manager->getClassMetadata(Category::class)->getFieldNames();

        // Selectionne les catégories dans la BDD
        $categoryFr = $repo->findAll();

        //dump($ville);

        //Permet l'affichage
        return $this->render('fr/show_fr_ville.html.twig', [
            'controller_name' => 'FrController',
            'colonnes' => $colonnes,
            'category' => $categoryFr,
            'ville' => $ville
        ]);
    }



}

