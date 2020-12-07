<?php

namespace App\Controller;

use App\Entity\Pays;
use App\Entity\Ville;
use App\Form\PaysType;
use App\Form\VilleType;
use App\Repository\PaysRepository;
use App\Repository\VilleRepository;
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
                'id' => $ville->getId() // On transmet le nouvel ID de pays
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




}
