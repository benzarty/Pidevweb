<?php

namespace App\Controller;

use App\Entity\Apprenant;
use App\Entity\Professeur;
use App\Repository\ApprenantRepository;
use App\Repository\ProfesseurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfesseurController extends AbstractController
{



    /**
     * @param ProfesseurRepository $repo
     * @return Response
     * @Route("/AfficeProf",name="aficherprof")
     */
    public function Affiche(ProfesseurRepository $repo)
    {

        $classroom = $repo->findAll();
        return $this->render('Professeur/Affiche.html.twig', ['articles' => $classroom]);
    }


    /**
     * @Route("/Professeur/new", name="new_Professeur")
     * Method({"GET", "POST"})
     */
    public function new(Request $request) {
        $article = new Professeur();
        $form = $this->createFormBuilder($article)
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('email', TextType::class)
            ->add('photo', TextType::class)
            ->add('password', TextType::class)
            ->add('specialite', TextType::class)
            ->add('profil', TextType::class)

            ->add('save', SubmitType::class, array(
                    'label' => 'Créer')
            )->getForm();


        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
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
        $article = $this->getDoctrine()->getRepository(Professeur::class)->find($id);

        return $this->render('Professeur/show.html.twig', array('article' => $article));
    }

    /**
     * @Route("/Prof/edit/{id}", name="edit_prof")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id) {
        $article = new Professeur();
        $article = $this->getDoctrine()->getRepository(Professeur::class)->find($id);

        $form = $this->createFormBuilder($article)
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('email', TextType::class)
            ->add('photo', TextType::class)
            ->add('password', TextType::class)
            ->add('specialite', TextType::class)
            ->add('profil', TextType::class)
            ->add('save', SubmitType::class, array(
                'label' => 'Modifier'
            ))->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('aficherprof');
        }

        return $this->render('Professeur/edit.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/Prof/delete/{id}",name="delete_prof")
     */
    public function delete(Request $request, $id) {
        $article = $this->getDoctrine()->getRepository(Professeur::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($article);
        $entityManager->flush();

        $response = new Response();
        $response->send();

        return $this->redirectToRoute('aficherprof');
    }
}
