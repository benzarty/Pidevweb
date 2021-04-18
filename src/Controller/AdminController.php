<?php

namespace App\Controller;

use App\Entity\Administrateur;
use App\Entity\Apprenant;
use App\Form\AdminFomType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminController extends AbstractController
{

    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/backendAdmin.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }


    /**
     * @Route("/home", name="home")
     */
    public function indexHomefront(): Response
    {
        return $this->render('HomeFront/FrontClient.html.twig');
    }
}
