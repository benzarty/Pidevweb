<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReclamationController extends AbstractController
{

    /**
     * @param ReclamationRepository $repo
     * @return Response
     * @Route("",name="Reclamation")
     */
    public function Affiche(ReclamationRepository $repo)
    {   $classroom = $repo->findAll();
        return $this->render('Reclamation/Affiche.html.twig', ['articles' => $classroom]);}


    /**
     * @Route("/Reclamation/new", name="new_Reclamation")
     * Method({"GET", "POST"})
     */

    public function new(Request $request) {
        $article = new Reclamation();
        $form = $this->createForm(ReclamationType::class,$article);
        $form->add('ajouter', SubmitType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('Reclamation');
        }
        return $this->render('Reclamation/NewReclamation.html.twig',['form' => $form->createView()]);
    }


    /**
     * @Route("/ReclamationInfo/{id}", name="Reclamation_show")
     */
    public function show($id) {
        $article = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
        return $this->render('Reclamation/show.html.twig', array('article' => $article)); }




    /**
     * @Route("/Reclamation/edit/{id}", name="edit_Reclamation")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id) {
        $article = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);

        $form = $this->createForm(ReclamationType::class,$article);
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

            return $this->redirectToRoute('Reclamation');
        }

        return $this->render('Reclamation/edit.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/Reclamation/delete/{id}",name="delete_prof")
     */
    public function delete(Request $request, $id) {
        $article = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($article);
        $entityManager->flush();

        $response = new Response();
        $response->send();

        return $this->redirectToRoute('Reclamation');
    }
}
