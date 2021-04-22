<?php

namespace App\Controller;

use App\Entity\Administrateur;
use App\Entity\Apprenant;
use App\Entity\Users;
use App\Form\AdminFomType;
use App\Repository\UsersRepository;
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
        if (($user->getRole() == "apprenant") and ($user->getStatus() == "True" ))
            return $this->render('HomeFront/FrontApprenantMain.html.twig');
        else if($user->getRole() == "professeur")
            return $this->render('Professeur/dashboardProf.html.twig');
        else if($user->getRole() == "admin")
            return $this->render('admin/backendAdmin.html.twig');
        else
            $this->addFlash(
                'info','Your have entred wrong Password or your account is blocked Sir or maybe you dont have access  !!');
            return $this->redirectToRoute('login');


    }




    /**
     * @Route("/", name="homee")
     */
    public function FontAllUsers()
    {

        return $this->render('HomeFront/HomeFrontAllUsers.html.twig');


    }

    /**
     * @param UsersRepository $repo
     * @return Response
     * @Route("/Unblock", name="Unblock")
     */
    public function UnblockUsersPage(UsersRepository $repo)
    {
        $classroom = $repo->findBy([
            'status' => 'false']);

        return $this->render('admin/UnblockUser.html.twig', ['articles' => $classroom]);

    }


    /**
     * @Route("/Admin/Unblock/{id}",name="unblockbenz")
     */
    public function unblock(Request $request, $id)
    {
        $article = $this->getDoctrine()->getRepository(Users::class)->find($id);

        $article->setStatus('True');
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        $response = new Response();
        $response->send();

        return $this->redirectToRoute('Unblock');
    }









}
