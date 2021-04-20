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
    public function home(Request $request, AuthenticationUtils $utils): \Symfony\Component\HttpFoundation\Response
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if ($user->getRole() == "apprenant")
            return $this->render('HomeFront/FrontApprenantMain.html.twig');
        else if($user->getRole() == "professeur")
            return $this->render('Test/professeur.html.twig');
        else
            return $this->redirectToRoute('hahah');


    }

    /**
     * @Route("/homee", name="homee")
     */
    public function home2(Request $request, AuthenticationUtils $utils): \Symfony\Component\HttpFoundation\Response
    {

        return $this->render('HomeFront/FrontApprenantMain.html.twig');


    }



}
