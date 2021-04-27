<?php

namespace App\Controller;

use App\Entity\Apprenant;
use App\Entity\Emploidetemps;
use App\Entity\Professeur;
use App\Entity\Users;
use App\Form\EmploiTempsType;
use App\Form\ProfesseurType;
use App\Repository\ProfesseurRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfesseurController extends AbstractController
{

    /**
     * @Route("/AfficheEmploiProf", name="AfficheEmploiProf")
     */
    public function AfficheEmploiProf(): Response
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $article = $this->getDoctrine()->getRepository(Emploidetemps::class)->findAll($user->getId());


        return $this->render('Professeur/GestionEmploitempsProf.html.twig',['articles' => $article]);
    }

    /**
     * @param UsersRepository $repo
     * @return Response
     * @Route("/AfficeProf",name="aficherprof")
     */
    public function Affiche(UsersRepository $repo)
    {

        $classroom = $repo->findBy([
            'role' => 'professeur']);
        return $this->render('Professeur/Affiche.html.twig', ['articles' => $classroom]);
    }


    /**
     * @Route("/Professeur/new", name="new_Professeur")
     * Method({"GET", "POST"})
     */
    public function new(Request $request) {
        $article = new Users();
        $form = $this->createForm(ProfesseurType::class,$article);
        $article->setRole("professeur");

        $form->add('ajouter', SubmitType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('photo')->getData();

            $fileName= md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('imagedirectory'),$fileName);


            $article->setPhoto($fileName);


            $article = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('aficherprof');
        }
        return $this->render('Professeur/NewProf.html.twig',['form' => $form->createView()]);
    }


    /**
     * @Route("/ProfInfo/{id}", name="Prof_show")
     */
    public function show($id) {
        $article = $this->getDoctrine()->getRepository(Users::class)->find($id);

        return $this->render('Professeur/show.html.twig', array('article' => $article));
    }

    /**
     * @Route("/Prof/edit/{id}", name="edit_prof")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id) {
        $article = $this->getDoctrine()->getRepository(Users::class)->find($id);

        $form = $this->createForm(ProfesseurType::class,$article);
        $form->add('Modifier', SubmitType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('photo')->getData();

            $fileName= md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('imagedirectory'),$fileName);


            $article->setPhoto($fileName);


            $article = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('aficherprof');
        }

        return $this->render('Professeur/edit.html.twig', ['form' => $form->createView()]);
    }


    /**
     * @Route("/Prof/deletenow/{id}",name="delete_profff")
     */
    public function deleteProff(Request $request, $id)
    {
        $article = $this->getDoctrine()->getRepository(Users::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($article);
        $entityManager->flush();

        $response = new Response();
        $response->send();

        return $this->redirectToRoute('aficherprof');
    }
    /**
     * @Route("/Prof/newEmploiTemps", name="newEmploiTemps")
     * Method({"GET", "POST"})
     */
    public function newEmploiTemps(Request $request)
    {        $user = $this->get('security.token_storage')->getToken()->getUser();

        $article = new Emploidetemps();
        $form = $this->createForm(EmploiTempsType::class, $article);
        $form->add('ajouter', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

$article->setIdprof($user);
            //$file = $article->getPhoto();
            $file = $form->get('emploi')->getData();

            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('imagedirectory'), $fileName);


            $article->setEmploi($fileName);


            $article = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('AfficheEmploiProf');
        }
        return $this->render('Professeur/AddEmploisTemps.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/SupprimerEmploiTemps/{id}",name="SupprimerEmploiTemps")
     */
    public function SupprimerEmploistemps(Request $request, $id)
    {
        $article = $this->getDoctrine()->getRepository(Emploidetemps::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($article);
        $entityManager->flush();

        $response = new Response();
        $response->send();

        return $this->redirectToRoute('AfficheEmploiProf');
    }


    /**
     * @Route("/showDetailEmploiProf/{id}", name="showDetailEmploiProf")
     */
    public function showDetailEmploiProf($id) {
        $article = $this->getDoctrine()->getRepository(Emploidetemps::class)->find($id);

        return $this->render('Professeur/DetailEmploiTemps.html.twig', array('article' => $article));
    }
}

