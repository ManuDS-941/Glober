<?php

namespace App\Controller;

use App\Entity\Pays;
use App\Repository\PaysRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndController extends AbstractController
{
    /**
     * @Route("/ind", name="ind")
     */
    public function index(): Response
    {
        return $this->render('ind/index.html.twig', [
            'controller_name' => 'IndController'
        ]);
    }

    /**
     * @Route("/ind", name="ind")
     */
    public function adminArticles(EntityManagerInterface $manager, PaysRepository $repo): Response
    {
        $colonnes = $manager->getClassMetadata(Pays::class)->getFieldNames();

        dump($colonnes);

        $pays = $repo->findAll();

    

        return $this->render('ind/index.html.twig', [
            'colonnes' => $colonnes
            
        ]);
    }

    /**
     * @Route("/ind/pondy", name="pondy")
     */
    public function pondy(): Response
    {
        return $this->render('ind/pondy.html.twig', [
            'controller_name' => 'IndController']);
    }
}
