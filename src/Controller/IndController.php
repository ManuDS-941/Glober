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
    public function index (VilleRepository $repo): Response
    {
    
        $ville = $repo->findAll();

        dump($ville);

        $villeind = [];

        foreach($ville as $pays)
        {
            if($pays->getPays()->getTitle() == 'Inde')
            {
                array_push($villeind, $pays);
            }

        }


        return $this->render('ind/index.html.twig', [
            'controller_name' => 'IndController',
            
            'ville' => $villeind
            
            
        ]);
    }

    /**
     * @Route("/ind/pondy/{id}", name="pondy")
     */
    public function VilleIN($id, VilleRepository $repo, CategoryRepository $repo1, LieuRepository $repo2): Response
    // $id : on récupère l'id de l'url dans une variable $id
    {

        $ville = $repo->findAll();
        $category = $repo1->findAll();
        $lieu = $repo2->findAll();

        dump($id); // // Verifie l'Id reçu
        // dump($ville); // Verifie le tableau des villes
        // dump($category); // Verifie le tableau des catégories
        dump($lieu); // Verifie le tableau des lieus

        return $this->render('ind/pondy.html.twig', [
            'id' => $id,
            'ville' => $ville,
            'category' => $category,
            'lieu' => $lieu
        ]);
    }

}


