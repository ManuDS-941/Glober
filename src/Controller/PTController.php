<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Entity\Ville;
use App\Entity\Category;
use App\Entity\Pays;
use App\Repository\LieuRepository;
use App\Repository\VilleRepository;
use App\Repository\CategoryRepository;
use App\Repository\PaysRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PTController extends AbstractController
{
    /**
     * @Route("/pt", name="pt")
     */
    public function index(VilleRepository $repo): Response
    {

        // Selectionne les données de Ville dans la BDD
        // $tableau = $manager->getRepository(Pays::class)->findBy(['title' => 'Portugal']);

        // dump($tableau);

        // Selectionne les villes dans la BDD
        $ville = $repo->findAll();

        // dump($ville);

        $villept = [];

        foreach($ville as $pays)
        {
        dump($pays->getPays()->getTitle());
            if($pays->getPays()->getTitle() == "Portugal")
            {
                array_push($villept, $pays);
            }
            dump($villept);

        }
        
        // dump($villept);


        return $this->render('pt/index.html.twig', [
            'controller_name' => 'PTController',
            'ville' => $villept
        ]);
    }

    /**
     * @Route("/pt/ville/{id}", name="villept")
     */
    public function VillePT(CategoryRepository $repo): Response
    {

        // dump($tableau);
        $category = $repo->findAll();

        // dump($category);

        $categorypt = [];

        foreach($category as $ville) 
        {
            //dump($ville->getVille()->getTitle()); // Je regarde la ville que je récupère
            if($ville->getVille()->getTitle() == 'Lisbonne')
            {
                array_push($categorypt, $ville);
            }
        }
        dump($categorypt);
        dump($ville);

        return $this->render('pt/ville.html.twig', [
            'category' => $categorypt
        ]);
    }

    // /**
    //  * @Route("/pt/ville/category/{id}", name"categorypt")
    //  */
    // public function CatPT(): Response
    // {
    //     return $this->render('pt/category.html.twig');
    // }



}
