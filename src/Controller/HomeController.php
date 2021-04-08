<?php

namespace App\Controller;

use App\Repository\Apprenant2Repository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @param Apprenant2Repository $repo
     * @return Response
     * @Route("/Afficec",name="hahah")
     */
    public function Affiche(Apprenant2Repository $repo)
    {

        $classroom = $repo->findAll();
        return $this->render('Apprenant/Affiche.html.twig', ['classroom' => $classroom]);
    }


}
