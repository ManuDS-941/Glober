<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Entity\Pays;
use App\Entity\Ville;
use App\Entity\Comment;
use App\Entity\Category;
use App\Form\CommentType;
use App\Form\CommentaireType;
use App\Repository\LieuRepository;
use App\Repository\PaysRepository;
use App\Repository\VilleRepository;
use App\Repository\CommentRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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
        // Selectionne les villes dans la BDD
        $ville = $repo->findAll();

        // dump($ville);

        $villept = [];

        foreach($ville as $pays)
        {
            // dump($pays->getPays()->getTitle()); // Verifie si on reçois bien le titre du pays dans le getteur

            if($pays->getPays()->getTitle() == "Portugal")
            {
                array_push($villept, $pays);
            }
            // dump($villept);

        }
        
        // dump($villept);


        return $this->render('pt/index.html.twig', [
            'controller_name' => 'PTController',
            'ville' => $villept
        ]);
    }

    /**
     * @Route("/pt/ville/{id}", name="villept")
     * 
     */
    public function VillePT($id, VilleRepository $repo, CategoryRepository $repo1, LieuRepository $repo2, Request $request): Response
    // $id : on récupère l'id de l'url dans une variable $id
    {
        
        $ville = $repo->findAll();
        $category = $repo1->findAll();
        $lieu = $repo2->findAll();

        $cat = $repo1->findBy(['ville' => $id]);
        
        dump($cat);

        // dump($request);

        //$query = $request->getRequestUri(); // Exemple du cas qui marche

        //$Monument = $request->query->get('title', "Monument" );
        //$Activite = $request->query->get('title', "Activite" );

        //dump($query);

        // dump($id); // // Verifie l'Id reçu
        // dump($ville); // Verifie le tableau des villes
        // dump($category); // Verifie le tableau des catégories
        dump($lieu); // Verifie le tableau des lieus

        return $this->render('pt/ville.html.twig', [
            'id' => $id,
            'ville' => $ville,
            'category' => $category,
            'lieu' => $lieu,
            'cat' => $cat,
            //'query' => $query,
            //'Monument' => $Monument,
            //'Activite' => $Activite
        ]);
    }

    /**
     * @Route("/pt/ville/lieu/{id}", name="lieupt")
     */
    public function CatPT($id, LieuRepository $repo, CommentRepository $repo1): Response
    {
        // dump($id);
        
        $comment = new Comment;
        
        //$formComment = $this->createForm(CommentaireType::class, $comment); // Créer un formulaire et on stock dans la variable $comment
        
        //dump($formComment);
        
        // $formComment->handleRequest($comment);
        
        
        $lieu = $repo->findAll();
        // dump($lieu);
        $selectcomment = $repo1->findAll();
        // dump($comment);

        return $this->render('pt/lieu.html.twig', [
            'id' => $id,
            'lieu' => $lieu,
            'comment' => $comment,
            //'formComment' => $formComment,
            'selectcomment' => $selectcomment
        ]);
    }



}
