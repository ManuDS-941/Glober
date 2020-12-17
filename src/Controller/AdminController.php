<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Entity\Pays;
use App\Entity\User;
use App\Entity\Ville;
use App\Form\LieuType;
use App\Form\PaysType;
use App\Form\UserType;
use App\Entity\Comment;
use App\Entity\Message;
use App\Form\VilleType;
use App\Entity\Category;
use App\Form\CommentType;
use App\Form\CategoryType;
use App\Repository\LieuRepository;
use App\Repository\PaysRepository;
use App\Repository\UserRepository;
use App\Repository\VilleRepository;
use App\Repository\CommentRepository;
use App\Repository\MessageRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/admin/pays", name="admin_pays")
     */
    public function AdminPays(PaysRepository $repo, EntityManagerInterface $manager): Response
    {
        
        $colonnes = $manager->getClassMetadata(Pays::class)->getFieldNames(); // Selectionne les métas données de Pays dans la Bdd
        
        dump($colonnes);
        
        $pays = $repo->findAll(); // Selectionne les pays de la BDD

        dump($pays);

        return $this->render('admin/admin_pays.html.twig', [
            'colonnes' => $colonnes,
            'pays' => $pays
        ]);
    }


    /**
     * @Route("/admin/pays/create", name="admin_pays_create")
     * @Route("/admin/pays/edit/{id}", name="admin_pays_edit")
     */
    public function AdminFormPays(Pays $pays = null, Request $request, EntityManagerInterface $manager): Response
    // On rajoute = null car sinon symfony cherche a récupérer un pays en BDD
    // Request $request : récupère les données du formulaire dans la variable $request
    // EntityManagerInterface : Sert a manipuler la BDD
    {
        if(!$pays) // Si le pays selectionné n'est pas nul on fait alors une modification et on entre pas dans le IF
        {
            $pays = new Pays;
        }

        dump($request); // On controle les valeurs saisie
        // dump($pays); // On controle si pays est bien null

        $formPays = $this->createForm(PaysType::class, $pays); // On créer le formulaire de PaysType et on stock dans la variable $pays

        $formPays->handleRequest($request); // Vérifie si tout les champs on été bien rempli et l'envoie dans le bon setter

        dump($request); 

        if($formPays->isSubmitted() && $formPays->isValid()) 
        {
            $manager->persist($pays); // On maintient l'insertion en BDD dans la variable $pays
            $manager->flush(); // On execute l'insertion

            $message = "Le pays a bien été ajouté !!";

            $this->addFlash('success', "Le pays a bien été ajouté !!");

            return $this->redirectToRoute('admin_pays', [
                'id' => $pays->getId() // On transmet le nouvel ID de pays
            ]);
        }


        return $this->render('admin/admin_pays_create.html.twig', [
            'formPays' => $formPays->createView(), // on créer une vision dans la variable formPays
            'Bouton' => $pays->getId() // Active Bouton dès qu'il y a un ID dans pays
        ]);
    }

    /**
     * @Route("/admin/pays/delete{id}", name="admin_pays_delete")
     */
    public function AdminDeletePays(Pays $pays, EntityManagerInterface $manager)
    {
        $manager->remove($pays); // Prépare pour garder en mémoire la requete Delete
        $manager->flush(); // Execute

        $this->addFlash('success', "Le Pays a bien été supprimé !!");

        return $this->redirectToRoute('admin_pays');
    }

    /**
     * @Route("/admin/ville", name="admin_ville")
     */
    public function AdminVille(VilleRepository $repo, EntityManagerInterface $manager): Response
    {
        $colonnes = $manager->getClassMetadata(Ville::class)->getFieldNames(); // Selectionne les métas données de la Ville dans la Bdd

        dump($colonnes);
        
        $ville = $repo->findAll(); // Selectionne les villes de la BDD

        dump($ville);


        return $this->render('admin/admin_ville.html.twig', [
            'colonnes' => $colonnes,
            'ville' => $ville
        ]);
    }

    /**
     * @Route("/admin/ville/create", name="admin_ville_create")
     * @Route("/admin/ville/edit/{id}", name="admin_ville_edit")
     */
    public function AdminFormVille(Ville $ville = null, Request $request, EntityManagerInterface $manager): Response
    // On rajoute = null car sinon symfony cherche a récupérer un ville en BDD
    // Request $request : récupère les données du formulaire dans la variable $request
    // EntityManagerInterface : Sert a manipuler la BDD
    {
        if(!$ville) // Si le ville selectionné n'est pas nul on fait alors une modification et on entre pas dans le IF
        {
            $ville = new Ville;
        }

        dump($request); // On controle les valeurs saisie
        dump($ville); // On controle si ville est bien null

        $formVille = $this->createForm(VilleType::class, $ville); // On créer le formulaire de VilleType et on stock dans la variable $ville

        $formVille->handleRequest($request); // Vérifie si tout les champs on été bien rempli et l'envoie dans le bon setter

        dump($request); 

        if($formVille->isSubmitted() && $formVille->isValid())
        {
            $manager->persist($ville); // On maintient l'insertion en BDD dans la variable $ville
            $manager->flush(); // On execute

            // if(!$ville->getId()) // A redevelopper
            // {
            //     $message = "La ville a bien été ajoutée";
            // }
            // else
            // {
            //     $message = "La ville a bien été modifiée";
            // }

            $this->addFlash('success', "La ville a bien été ajouté !!");

            return $this->redirectToRoute('admin_ville', [
                'id' => $ville->getId() // On transmet le nouvel ID de ville
            ]);
        }


        return $this->render('admin/admin_ville_create.html.twig', [
            'formVille' => $formVille->createView(),
            'Bouton' => $ville->getId() // Active Bouton dès qu'il y a un ID dans ville
            
        ]);
    }

    /**
     * @Route("/admin/ville/delete{id}", name="admin_ville_delete")
     */
    public function AdminDeleteVille(Ville $ville, EntityManagerInterface $manager)
    {
        $manager->remove($ville); // Prépare pour garder en mémoire la requete Delete
        $manager->flush(); // Execute

        $this->addFlash('success', "La ville a bien été supprimée !!");

        return $this->redirectToRoute('admin_ville');
    }

    /**
     * @Route("/admin/category", name="admin_category")
     */
    public function AdminCategory(EntityManagerInterface $manager, CategoryRepository $repo): Response
    // EntityManagerInterface $manager : Agit sur la BDD et stock dans manager
    // CategoryRepository $repo : Selectionne dans la BDD
    {
        $tableau = $manager->getClassMetadata(Category::class)->getFieldNames(); // Selectionne les métas données des catégories dans la Bdd 

        dump($tableau);
        
        $category = $repo->findAll(); // Selectionne les villes de la BDD

        dump($category);

        return $this->render('admin/admin_category.html.twig', [
            'tableau' => $tableau,
            'category' => $category
        ]);
    }

    /**
     * @Route("/admin/category/create", name="admin_category_create")
     * @Route("/admin/category/edit/{id}", name="admin_category_edit")
     */
    public function AdminFormCategory(Category $category = null, Request $request, EntityManagerInterface $manager): Response
    // On rajoute = null car sinon symfony cherche a récupérer une categorie en BDD
    // Request $request : récupère les données du formulaire dans la variable $request
    // EntityManagerInterface : Sert a manipuler la BDD
    {
        if(!$category) // Si le catégorie selectionné n'est pas nul on fait alors une modification et on entre pas dans le IF
        {
            $category = new Category;
        }
        
        dump($request); // On controle les valeurs saisie
        dump($category); // On controle si category est bien null

        $formCategory = $this->createForm(CategoryType::class, $category); // On créer le formulaire de CategoryType et on stock dans la variable $catégory

        $formCategory->handleRequest($request); // Vérifie si tout les champs on été bien rempli et l'envoie dans le bon setter

        dump($request); 

        if($formCategory->isSubmitted() && $formCategory->isValid())
        {
            $manager->persist($category); // On maintient l'insertion en BDD dans la variable $category
            $manager->flush(); // On execute

            // if(!$ville->getId()) // A redevelopper
            // {
            //     $message = "La Categorie a bien été ajoutée";
            // }
            // else
            // {
            //     $message = "La Categorie a bien été modifiée";
            // }

            $this->addFlash('success', "La catégorie a bien été ajoutée !!");

            return $this->redirectToRoute('admin_category', [
                'id' => $category->getId() // On transmet le nouvel ID de category
            ]);
        }

        return $this->render('admin/admin_category_create.html.twig', [
            'formCategory' => $formCategory->createView(),
            'Bouton' => $category->getId() // Active Bouton dès qu'il y a un ID dans categorie

        ]);
    }

    /**
     * @Route("/admin/category/delete/{id}", name="admin_category_delete")
     */
    public function AdminDeleteCategory(Category $category, EntityManagerInterface $manager)
    {
        $manager->remove($category); // Prépare pour garder en mémoire la requete Delete
        $manager->flush(); // Execute

        $this->addFlash('success', "La Catégorie a bien été supprimée !!");

        return $this->redirectToRoute('admin_category');
    }

    /**
     * @Route("/admin/lieu", name="admin_lieu")
     */
    public function AdminLieu(EntityManagerInterface $manager, LieuRepository $repo): Response
    // EntityManagerInterface $manager : Agit sur la BDD et stock dans manager
    // LieuRepository $repo : Selectionne dans la BDD
    {
        $tableau = $manager->getClassMetadata(Lieu::class)->getFieldNames(); // Selectionne les métas données des lieux dans la Bdd 

        dump($tableau);
        
        $lieu = $repo->findAll(); // Selectionne les lieux de la BDD

        dump($lieu);

        return $this->render('admin/admin_lieu.html.twig', [
            'tableau' => $tableau,
            'lieu' => $lieu
        ]);
    }

    /**
     * @Route("/admin/lieu/create", name="admin_lieu_create")
     * @Route("/admin/lieu/edit/{id}", name="admin_lieu_edit")
     */
    public function AdminFormLieu(Lieu $lieu = null, Request $request, EntityManagerInterface $manager): Response
    // On rajoute = null car sinon symfony cherche a récupérer une categorie en BDD
    // Request $request : récupère les données du formulaire dans la variable $request
    // EntityManagerInterface : Sert a manipuler la BDD
    {
        if(!$lieu) // Si le lieu selectionné n'est pas nul on fait alors une modification et on entre pas dans le IF
        {
            $lieu = new Lieu;
        }
        
        dump($request); // On controle les valeurs saisie
        dump($lieu); // On controle si lieu est bien null

        $formLieu = $this->createForm(LieuType::class, $lieu); // On créer le formulaire de LieuType et on stock dans la variable $lieu

        $formLieu->handleRequest($request); // Vérifie si tout les champs on été bien rempli et l'envoie dans le bon setter

        dump($request); 

        if($formLieu->isSubmitted() && $formLieu->isValid())
        {
            $manager->persist($lieu); // On maintient l'insertion en BDD dans la variable $lieu
            $manager->flush(); // On execute

            // if(!$lieu->getId()) // A redevelopper
            // {
            //     $message = "La Categorie a bien été ajoutée";
            // }
            // else
            // {
            //     $message = "La Categorie a bien été modifiée";
            // }

            $this->addFlash('success', "Le lieu a bien été ajoutée !!");

            return $this->redirectToRoute('admin_lieu', [
                'id' => $lieu->getId() // On transmet le nouvel ID de lieu
                
            ]);
        }

        return $this->render('admin/admin_lieu_create.html.twig', [
            'formLieu' => $formLieu->createView(),
            'Bouton' => $lieu->getId() // Active Bouton dès qu'il y a un ID dans lieu
            


        ]);
    }

    /**
     * @Route("/admin/lieu/delete/{id}", name="admin_lieu_delete")
     */
    public function AdminDeleteLieu(Lieu $lieu, EntityManagerInterface $manager)
    {
        $manager->remove($lieu); // Prépare pour garder en mémoire la requete Delete
        $manager->flush(); // Execute

        $this->addFlash('success', "Le Lieu a bien été supprimée !!");

        return $this->redirectToRoute('admin_lieu');
    }

    /**
     * @Route("/admin/comment", name="admin_comment")
     */
    public function AdminComment(EntityManagerInterface $manager, CommentRepository $repo): Response
    // EntityManagerInterface $manager : Agit sur la BDD et stock dans manager
    // LieuRepository $repo : Selectionne dans la BDD
    {
        $tableau = $manager->getClassMetadata(Comment::class)->getFieldNames(); // Selectionne les métas données des commentaires dans la Bdd 

        dump($tableau);
        
        $comment = $repo->findAll(); // Selectionne les commentaires de la BDD

        dump($comment);

        return $this->render('admin/admin_comment.html.twig', [
            'tableau' => $tableau,
            'comment' => $comment
        ]);
    }

    /**
     * @Route("/admin/comment/create", name="admin_comment_create")
     * @Route("/admin/comment/edit/{id}", name="admin_comment_edit")
     */
    public function AdminFormComment(Comment $comment = null, Request $request, EntityManagerInterface $manager): Response
    // On rajoute = null car sinon symfony cherche a récupérer une categorie en BDD
    // Request $request : récupère les données du formulaire dans la variable $request
    // EntityManagerInterface : Sert a manipuler la BDD
    {
        if(!$comment) // Si le comment selectionné n'est pas nul on fait alors une modification et on entre pas dans le IF
        {
            $comment = new Comment;
        }
        
        dump($request); // On controle les valeurs saisie
        dump($comment); // On controle si comment est bien null

        $formComment = $this->createForm(CommentType::class, $comment); // On créer le formulaire de CommentType et on stock dans la variable $comment

        $formComment->handleRequest($request); // Vérifie si tout les champs on été bien rempli et l'envoie dans le bon setter

        dump($request); 

        if($formComment->isSubmitted() && $formComment->isValid())
        {
            if(!$comment->getId()) // Si la variable $comment n'a pas un ID
            {
                $comment->setCreatedAt(new \DateTime()); // On ajoute une nouvel date a la variable comment
            }

            $manager->persist($comment); // On maintient l'insertion en BDD dans la variable $comment
            $manager->flush(); // On execute

            // if(!$ville->getId()) // A redevelopper
            // {
            //     $message = "La Categorie a bien été ajoutée";
            // }
            // else
            // {
            //     $message = "La Categorie a bien été modifiée";
            // }

            $this->addFlash('success', "Le commentaire a bien été ajoutée !!");

            return $this->redirectToRoute('admin_comment', [
                'id' => $comment->getId() // On transmet le nouvel ID de comment
            ]);
        }

        return $this->render('admin/admin_comment_create.html.twig', [
            'formComment' => $formComment->createView(),
            'Bouton' => $comment->getId() // Active Bouton dès qu'il y a un ID dans comment

        ]);
    }

    /**
     * @Route("/admin/comment/delete/{id}", name="admin_comment_delete")
     */
    public function AdminDeleteComment(Comment $comment, EntityManagerInterface $manager)
    {
        $manager->remove($comment); // Prépare pour garder en mémoire la requete Delete
        $manager->flush(); // Execute

        $this->addFlash('success', "Le Commentaire a bien été supprimée !!");

        return $this->redirectToRoute('admin_comment');
    }



    /**
     * @Route("/admin/user", name="admin_user")
     */
    public function AdminUser(EntityManagerInterface $manager, UserRepository $repo)
    {
        $tableau = $manager->getClassMetadata(User::class)->getFieldNames();
        
        dump($tableau);

        $user = $repo->findAll();

        dump($user);

        return $this->render('admin/admin_user.html.twig', [
            'tableau' => $tableau,
            'user' => $user
        ]);
    }

    /**
     * @Route("/admin/user/edit/{id}", name="admin_user_edit")
     */
    public function AdminEditUser(User $user, Request $request, EntityManagerInterface $manager): Response
    // On rajoute = null car sinon symfony cherche a récupérer une categorie en BDD
    // Request $request : récupère les données du formulaire dans la variable $request
    // EntityManagerInterface : Sert a manipuler la BDD
    {
        
        dump($request); // On controle les valeurs saisie
        dump($user); // On controle si les valeurs de User

        $formUser = $this->createForm(UserType::class, $user); // On créer le formulaire de UserType et on stock dans la variable $user

        $formUser->handleRequest($request); // Vérifie si tout les champs on été bien rempli et l'envoie dans le bon setter

        dump($request); 

        if($formUser->isSubmitted() && $formUser->isValid())
        {
            
            $manager->persist($user); // On maintient l'insertion en BDD dans la variable $user
            $manager->flush(); // On execute

            // if(!$ville->getId()) // A redevelopper
            // {
            //     $message = "La Categorie a bien été ajoutée";
            // }
            // else
            // {
            //     $message = "La Categorie a bien été modifiée";
            // }

            $this->addFlash('success', "L'utilisateur a bien été modifiée !!");

            return $this->redirectToRoute('admin_user', [
                'id' => $user->getId() // On transmet le nouvel ID de User
            ]);
        }

        return $this->render('admin/admin_user_edit.html.twig', [
            'formUser' => $formUser->createView()

        ]);
    }

    /**
     * @Route("/admin/user/delete/{id}", name="admin_user_delete")
     */
    public function AdminDeleteUser(User $user, EntityManagerInterface $manager)
    {
        $manager->remove($user);
        $manager->flush();

        $this->addFlash('success', "Le membre a bien été supprimer");

        return $this->redirectToRoute('admin_user');
    }



    /**
     * @Route("/admin/message", name="admin_message")
     */
    public function AdminMessage(EntityManagerInterface $manager, MessageRepository $repo): Response
    // EntityManagerInterface $manager : Agit sur la BDD et stock dans manager
    // MessageRepository $repo : Selectionne dans la BDD
    {
        $tableau = $manager->getClassMetadata(Message::class)->getFieldNames(); // Selectionne les métas données des messages dans la Bdd 

        dump($tableau);
        
        $message = $repo->findAll(); // Selectionne les messages contacts de la BDD

        dump($message);

        return $this->render('admin/admin_message.html.twig', [
            'tableau' => $tableau,
            'message' => $message
        ]);
    }

    /**
     * @Route("/admin/message/delete/{id}", name="admin_message_delete")
     */
    public function AdminDeleteMessage(Message $message, EntityManagerInterface $manager)
    {
        $manager->remove($message); // Prépare pour garder en mémoire la requete Delete
        $manager->flush(); // Execute

        $this->addFlash('success', "Le message a bien été supprimé");

        return $this->redirectToRoute('admin_message');
    }


}
