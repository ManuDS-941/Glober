<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, EntityManagerInterface $manager): Response   //dependance = tout ce dont la fonction a besoin pour focntionner, request sert à recup les données dans le formulaire
    {
        
        // dump($message); // dump sert à vérifier ce que j'ai dans la variable 
        $message = new Message;

        $formMessage = $this->createForm(ContactType::class, $message);// ContactType = from, qui détient toutes les données de mon entité, toutes données elle va les stocker dans la varible contact, grâce à la méthode createForm je vais créer le formulaire et je vais les injécter dans la variable formcontact 

        $formMessage->handleRequest($request); // cette ligne sert à vérifier si les champs sont bien remplis et envoyés dans les setters
        dump($request);

       

        // if($request->request->count())
        // {
        

        //     $message->setNom($request->request->get('nom'))
        //             ->setPrenom($request->request->get('prenom'))
        //             ->setEmail($request->request->get('email'))
        //             ->setMessage($request->request->get('message'))
        //             ->setCreatedAt( new \DateTime);

        //     $manager->persist($message);
        //     $manager->flush();
        //     $this->addFlash('success', 'Votre message a bien été envoyé');
        //     return $this->redirectToRoute('contact'); // on redirige l'utilisateur vers la page contact
        // }



        if($formMessage->isSubmitted() && $formMessage->isValid())
        {

            $message->setCreatedAt(new \DateTime());

            $manager->persist($message);
            $manager->flush();
            $this->addFlash('success', 'Votre message a bien été envoyé');
            return $this->redirectToRoute('contact'); // on redirige l'utilisateur vers la page contact
        }

        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'formMessage' => $formMessage->createView() // je récupère les données de formContact et je les injecte dans le string form contact que je pourrais utiliser dans le template 
            
        ]);
    }

}
