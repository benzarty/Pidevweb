<?php

namespace App\Controller;

use App\Entity\Apprenant;
use App\Entity\Emploidetemps;
use App\Entity\Users;
use App\Form\ApprenantInscriptionType;
use App\Form\ApprenantType;
use App\Repository\ApprenantRepository;
use App\Repository\EmploidetempsRepository;
use App\Repository\UsersRepository;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ApprenantController extends AbstractController
{

    /**
     * @param UsersRepository $repo
     * @return Response
     * @Route("/Afficec",name="hahah")
     */
    public function Affiche(UsersRepository $repo)
    {

        $classroom = $repo->findBy(['role' => 'apprenant']);
        return $this->render('Apprenant/Affiche.html.twig', ['articles' => $classroom]);
    }


    /**
     * @Route("/Apprenant/new", name="new_apprenant")
     * Method({"GET", "POST"})
     */
    public function new(Request $request)
    {
        $article = new Users();
        $form = $this->createForm(ApprenantType::class, $article);
        $article->setRole("apprenant");
        $form->add('ajouter', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            //$file = $article->getPhoto();
            $file = $form->get('photo')->getData();

            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('imagedirectory'), $fileName);


            $article->setPhoto($fileName);


            $article = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('hahah');
        }
        return $this->render('Apprenant/NewApprenant.html.twig', ['form' => $form->createView()]);
    }


    /**
     * @Route("/Apprenant/{id}", name="apprenant_show")
     */
    public function show($id)
    {
        $article = $this->getDoctrine()->getRepository(Users::class)->find($id);

        return $this->render('Apprenant/show.html.twig', array('article' => $article));
    }

    /**
     * @Route("/Apprenant/edit/{id}", name="edit_apprenant")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id)
    {
        $article = $this->getDoctrine()->getRepository(Users::class)->find($id);

        $form = $this->createForm(ApprenantType::class, $article);
        $form->add('Modifier', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $file = $form->get('photo')->getData();

            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('imagedirectory'), $fileName);


            $article->setPhoto($fileName);


            $article = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('hahah');
        }

        return $this->render('Apprenant/edit.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/Apprenant/delete/{id}",name="delete_apprenant")
     */
    public function delete(Request $request, $id)
    {
        $article = $this->getDoctrine()->getRepository(Users::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($article);
        $entityManager->flush();

        $response = new Response();
        $response->send();

        return $this->redirectToRoute('hahah');
    }


    /**
     * @Route("/RegisterApprenant",name="RegisterApprenanr")
     * Method({"GET", "POST"})
     */
    public function RegisterApprenant(Request $request)
    {
        $article = new Users();
        $form = $this->createForm(ApprenantInscriptionType::class, $article);
        $form->add('ajouter', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $article->setStatus("False");
            $article->setRole("apprenant");

            $file = $form->get('photo')->getData();

            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('imagedirectory'), $fileName);


            $article->setPhoto($fileName);


            $article = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            $this->addFlash('info', 'Your request has been added succesfully !!');

            return $this->redirectToRoute('RegisterApprenanr');
        }
        return $this->render('Apprenant/Goregister.html.twig', ['form' => $form->createView()]);
    }


    /**
     * @Route("/HomeGeneral", name="HomeGeneral")
     */
    public function home2(Request $request, AuthenticationUtils $utils): \Symfony\Component\HttpFoundation\Response
    {

        return $this->render('HomeFront/FrontApprenantMain.html.twig');


    }


    /**
     * @Route("/PagesFrontApprenant", name="PagesFrontApprenant")
     */
    public function Pages(Request $request, AuthenticationUtils $utils): \Symfony\Component\HttpFoundation\Response
    {

        return $this->render('HomeFront/FrontApprenantPagesAfterLogin.html.twig');


    }

    /**
     * @Route("/ResetPasswordApprenant", name="ResetPasswordApprenant")
     */
    public function ResetPasswordApprenant(Request $request)
    {
        $article = $this->getDoctrine()->getRepository(Users::class);

        $form = $this->createForm(ApprenantType::class, $article);
        $form->add('Modifier', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $article = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('hahah');
        }

        return $this->render('Apprenant/ResetPasswordApprenant.html.twig', ['form' => $form->createView()]);
    }


    /**
     * @param EmploidetempsRepository $repo
     * @return Response
     * @Route("/AfficheALLEmploi",name="AfficheALLEmploi")
     */
    public function AfficheAllEmplois(EmploidetempsRepository $repo)
    {

        $article = $this->getDoctrine()->getRepository(Emploidetemps::class)->findAll();

        return $this->render('Apprenant/AfficheTousEmploiTemps.html.twig', ['articles' => $article]);
    }


    /**
     * @Route("/EmploiDetailApprenant/{id}", name="EmploiDetailApprenant")
     */
    public function showDetailEmploiApprenant($id)
    {
        $article = $this->getDoctrine()->getRepository(Emploidetemps::class)->find($id);

        return $this->render('Apprenant/showDetailEmploiApprenant.html.twig', ['articles' => $article]);
    }


    /**
     * @Route("/ReglageProfilApprenant", name="ReglageProfilApprenant")
     * Method({"GET", "POST"})
     */
    public function ReglageProfilApprenant(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $article = $this->getDoctrine()->getRepository(Users::class)->find($user->getId());

        $form = $this->createForm(ApprenantInscriptionType::class, $article);
        $form->add('Modifier Profil', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $file = $form->get('photo')->getData();

            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('imagedirectory'), $fileName);


            $article->setPhoto($fileName);


            $article = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('Apprenant/EditProfilApprenant.html.twig', ['form' => $form->createView()]);
    }






}
