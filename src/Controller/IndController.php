<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Entity\Pays;
use App\Entity\Ville;
use App\Entity\Comment;
use App\Entity\Category;
use App\Form\CommentType;
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

 /**
     * @Route("/ind/ville/lieu/{id}", name="comment")
     */
    public function CatIN($id, LieuRepository $repo, Request $request, Lieu $lieu, CommentRepository $repo1, EntityManagerInterface $manager): Response
    {
        // dump($id);
        
        $comment = new Comment;
        
        $formComment = $this->createForm(CommentType::class, $comment); // Cr�er un formulaire et on stock dans la variable $comment
        
        //dump($formComment);
        dump($request);
        
        $formComment->handleRequest($request);
        dump($formComment);

        if ($formComment->isSubmitted() && $formComment->isValid()) {
            $username = $this->getUser()->getUsername();
            dump($username);

            // On renseigne le setter de l'auteur afin qu'il soit automatiquement compris dans le commentaire
            $comment->setPseudo($username);
            $comment->setCreatedAt(new \DateTime); // on insére une date de création du commentaire
            $comment->setLieu($lieu); // on relie le commentaire à l'article (clé étrangère)

            $manager->persist($comment); // on prépare l'insertion
            $manager->flush(); // on execute l'insertion

            // Envoi d'un message de validation
            $this->addFlash('success', "Le commentaire a bien été posté !");

            return $this->redirectToRoute('comment', [
                'id' => $lieu->getId()
            ]);
        }

        
        $lieu = $repo->findAll();
        // dump($lieu);
        $selectcomment = $repo1->findAll();
        // dump($comment);

        return $this->render('ind/comment.html.twig', [
            'id' => $id,
            'lieu' => $lieu,
            'comment' => $comment,
            'formComment' => $formComment->createView(),
            'selectcomment' => $selectcomment
        ]);
    }
}


