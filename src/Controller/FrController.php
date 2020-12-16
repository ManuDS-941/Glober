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

class FrController extends AbstractController
{
    /**
     * @Route("/fr", name="fr")
     */
    public function index(VilleRepository $repo): Response
    { 
        // Selectionne les villes dans la BDD
        $ville = $repo->findAll();
        
        $villesFr = [];

        foreach($ville as $pays){
        // dump($pays->getPays()->getTitle());
            if($pays->getPays()->getTitle() == "France")
            {
                array_push($villesFr, $pays);
            }
            //dump($villesFr);
        }

        // dump($villesFr);

        //Permet l'affichage
        return $this->render('fr/index_fr.html.twig', [
            'controller_name' => 'FrController',
            'ville' => $villesFr
        ]);
    }

    /**
     * @Route("/fr/ville/{id}", name="villeFr")
     */
    public function VilleFr($id, VilleRepository $repo, CategoryRepository $repo1, LieuRepository $repo2): Response
    // $id : on récupère l'id de l'url dans une variable $id
    {

        $ville = $repo->findAll();
        $category = $repo1->findAll();
        $lieu = $repo2->findAll();

        $cat = $repo1->findBy(['ville' => $id]);
        dump($cat);

        // dump($id); // // Verifie l'Id reçu
        // dump($ville); // Verifie le tableau des villes
        // dump($category); // Verifie le tableau des catégories
        // dump($lieu); // Verifie le tableau des lieus

        return $this->render('fr/ville.html.twig', [
            'id' => $id,
            'ville' => $ville,
            'category' => $category,
            'lieu' => $lieu,
            'cat' => $cat
        ]);
    
    }

    /**
     * @Route("/fr/lieu/{id}", name="lieuFr")
     */
    public function CatFr($id, LieuRepository $repo, Lieu $lieu, CommentRepository $repo1, Request $request, EntityManagerInterface $manager): Response
    {
        // dump($id);
        $lieu2 = $repo->findAll();
        dump($lieu2);


        $comment = new Comment;
        // dump($comment);

        $formComment = $this->createForm(CommentaireType::class, $comment);   // importation du formulaire d'ajout de commentaire relié à l'entité $comment
        dump($formComment);
        
        $formComment->handleRequest($request);   // on rempli l'objet (entité) $comment avec les données saisies dans le formulaire
        
        // Si le formulaire a bien été validé, on entre dans la condition IF
        if($formComment->isSubmitted() && $formComment->isValid())
        {
            // getUser() : permettant de récupérer les données de l'utilisateur en session
            // On stock le nom d'utilisateur dans la variable ¤username
            $username = $this->getUser()->getUsername();
            dump($username);
        
            // On renseigne le setter de l'auteur afin qu'il soit automatiquement compris dans le commentaire
            $comment->setPseudo($username);
            $comment->setCreatedAt(new \DateTime);   // on insère une date de création du commentaire
            $comment->setLieu($lieu);   // On relie le commentaire au lieu (clé étrangère)
        
        
            $manager->persist($comment);   // on prépare l'insertion
            $manager->flush();   // on execute l'insertion
        
            // Envoi d'un message de validation
            $this->addFlash('success', "Le commentaire a bien été posté !");
        
            // On redirige vers la page du lieu après l'insertion du commentaire
            return $this->redirectToRoute('lieuFr',[
                'id' => $lieu->getId()
            ]);
        }

        return $this->render('fr/lieufr.html.twig', [
            'id' => $id,
            'lieu' => $lieu,
            'lieu2' => $lieu2,
            'comment' => $comment,
            'formComment' => $formComment->createView()
        ]);
    
    }



}

