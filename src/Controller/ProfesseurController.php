<?php

namespace App\Controller;

use App\Entity\Apprenant;
use App\Entity\Professeur;
use App\Form\ProfesseurType;
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
        $form = $this->createForm(ProfesseurType::class,$article);
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
        $article = $this->getDoctrine()->getRepository(Professeur::class)->find($id);

        return $this->render('Professeur/show.html.twig', array('article' => $article));
    }

    /**
     * @Route("/Prof/edit/{id}", name="edit_prof")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id) {
        $article = $this->getDoctrine()->getRepository(Professeur::class)->find($id);

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
        $article = $this->getDoctrine()->getRepository(Professeur::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($article);
        $entityManager->flush();

        $response = new Response();
        $response->send();

        return $this->redirectToRoute('aficherprof');
    }
}
