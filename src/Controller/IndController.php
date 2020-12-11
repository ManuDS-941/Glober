<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Entity\Pays;
use App\Entity\Ville;
use App\Entity\Category;
use App\Repository\LieuRepository;
use App\Repository\PaysRepository;
use App\Repository\VilleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndController extends AbstractController
{
 

    /**
     * @Route("/ind", name="ind")
     */
    public function adminArticles(EntityManagerInterface $manager, VilleRepository $repo): Response
    {
        $colonnes = $manager->getClassMetadata(Ville::class)->getFieldNames();

        dump($colonnes);

        $ville = $repo->findAll();

        dump($ville);


        return $this->render('ind/index.html.twig', [
            'controller_name' => 'IndController',
            'colonnes' => $colonnes,
            'ville' => $ville
            
            
        ]);
    }

    /**
     * @Route("/ind/pondy/{id}", name="pondy")
     */
    public function pondy(EntityManagerInterface $manager, CategoryRepository $repo1, Category $category, Ville $ville): Response
    {
        $colonnes = $manager->getClassMetadata(Category::class)->getFieldNames();

        dump($colonnes);

        //  $category = $repo1->findAll();

        dump($category);

        return $this->render('ind/pondy.html.twig', [
            'controller_name' => 'IndController',
            'colonnes' => $colonnes,
            'category' => $category,
            'ville' => $ville
            ]);
    }


}


