<?php

namespace App\Controller;

use App\Entity\Administrateur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;



class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     * @param Request $request
     * @param AuthenticationUtils $utils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(Request $request, AuthenticationUtils $utils): \Symfony\Component\HttpFoundation\Response
    {

        $error = $utils->getLastAuthenticationError();
        $lastUsername = $utils->getLastUsername();

        return $this->render('security/LoginLogin.html.twig', [
            'error' => $error,
            'last_username' => $lastUsername
        ]);


    }

    /**
     * @Route("/hom", name="hom")
     */
    public function home(Request $request, AuthenticationUtils $utils): \Symfony\Component\HttpFoundation\Response
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if ($user->getRole() == 1)
            return $this->render('base.html.twig');
        else
            return $this->render('security/home.html.twig');

    }


    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/base", name="base")
     */
    public function back()
    {
        return $this->render('acceuilback.html.twig', [

            $this->getUser()->getUsername()]);

    }








}
