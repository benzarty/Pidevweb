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
use App\Entity\Users;

class ReclamationController extends AbstractController
{

    /**
     * @param ReclamationRepository $repo
     * @return Response
     * @Route("/R",name="Reclamation")
     */
    public function Affiche(ReclamationRepository $repo)
    {   $classroom = $repo->findBy(['msgA' => 'ABR']);
        $NotifNB = $repo->NotifCount();
        return $this->render('Reclamation/Affiche.html.twig', ['articles' => $classroom ,'NotifNB' => $NotifNB]);}


    /**
     * @param ReclamationRepository $repo
     * @return Response
     * @Route("/RC",name="RC")
     */
    public function AfficheRC(Request $request ,ReclamationRepository $repo)
    {
      $recl = $repo->findAllRC();
        $NotifNB = $repo->NotifCount();
        return $this->render('Reclamation/AfficheRC.html.twig',["articles" => $recl ,'NotifNB' => $NotifNB]);
    }


    /**
     * @param ReclamationRepository $repo
     * @return Response
     * @Route("/RA",name="RA")
     */
    public function AfficheRA(Request $request ,ReclamationRepository $repo)
    {
        $recl = $repo->findBy(['msgA' => 'AARCHIVE']);
        $NotifNB = $repo->NotifCount();
        return $this->render('Reclamation/AfficheRA.html.twig',["articles" => $recl ,'NotifNB' => $NotifNB]);
    }


    /**
     * @param ReclamationRepository $repo
     * @Route("/Messagerie/{id}",name="Messagerie")
     */
    public function Messagerie(Request $request ,$id ,ReclamationRepository $repo)
    {
        $article = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
        $form = $this->createForm(ReclamationType::class,$article);
        $form->add('Modifier', SubmitType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute('Reclamation');
        }
        return $this->render('Reclamation/Messagerie.html.twig', ['form' => $form->createView()]);
    }



    /**
     * @Route("/Reclamation/new", name="new_Reclamation")
     * @return Response
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
     * @Route("/Reclamation/edit/{id}", name="edit_Reclamation")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id) {
        $article = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
        $form = $this->createForm(ReclamationType::class,$article);
        $form->add('Modifier', SubmitType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute('Reclamation');
        }
        return $this->render('Reclamation/edit.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/Reclamation/corbeille/{id}",name="corbeille")
     */
    public function corbeille(Request $request, $id) {
        $entityManager = $this->getDoctrine()->getManager();
        $article = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
        $article->setMsgA('ACORBEILLE');
        $entityManager->persist($article);
        $entityManager->flush();
       return $this->redirectToRoute('Reclamation');}


    /**
     * @Route("/Reclamation/restore/{id}",name="restore")
     */
    public function restaurer(Request $request, $id) {
        $entityManager = $this->getDoctrine()->getManager();
        $article = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
        $article->setMsgA('ABR');
        $entityManager->persist($article);
        $entityManager->flush();
        return $this->redirectToRoute('RC');}

    /**
     * @Route("/Reclamation/archive/{id}",name="archive")
     */
    public function archiver(Request $request, $id) {
        $entityManager = $this->getDoctrine()->getManager();
        $article = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
        $article->setMsgA('AARCHIVE');
        $entityManager->persist($article);
        $entityManager->flush();
        return $this->redirectToRoute('Reclamation');}

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

        return $this->redirectToRoute('RC');
    }

    //////--------------------------------------ESPACE USER ----------------------------------------------/////////////////////

    /**
     * @param ReclamationRepository $repo
     * @return Response
     * @Route("/FR",name="FReclamation")
     */
    public function FAffiche(ReclamationRepository $repo)
    {   $classroom = $repo->findBy(['msgA' => 'ABR']);
        $NotifNB = $repo->NotifCount();
        return $this->render('Reclamation/FReclamation.html.twig', ['articles' => $classroom ,'NotifNB' => $NotifNB]);}


    /**
     * @param ReclamationRepository $repo
     * @return Response
     * @Route("/FRC",name="FRC")
     */
    public function FAfficheRC(Request $request ,ReclamationRepository $repo)
    {
        $recl = $repo->findAllRC();
        return $this->render('Reclamation/FAfficheRC.html.twig',array("articles" => $recl));
    }


    /**
     * @param ReclamationRepository $repo
     * @return Response
     * @Route("/FRA",name="FRA")
     */
    public function FAfficheRA(Request $request ,ReclamationRepository $repo)
    {
        $recl = $repo->findBy(['msgA' => 'AARCHIVE']);
        return $this->render('Reclamation/FAfficheRA.html.twig', ['articles' => $recl]);
    }


    /**
     * @Route("/FReclamation/new", name="new_FReclamation")
     * @return Response
     * Method({"GET", "POST"})
     */

    public function Fnew(Request $request) {
        $article = new Reclamation();
        $article->setMsgA('ABR');
        $article->setExp('USER');
        $form = $this->createForm(ReclamationType::class,$article);
        $form->add('ajouter', SubmitType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('FReclamation');
        }
        return $this->render('Reclamation/FNewReclamation.html.twig',['form' => $form->createView()]);
    }



    /**
     * @Route("/FReclamation/edit/{id}", name="edit_FReclamation")
     * Method({"GET", "POST"})
     */
    public function Fedit(Request $request, $id) {
        $article = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
        $form = $this->createForm(ReclamationType::class,$article);
        $form->add('Modifier', SubmitType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute('FReclamation');
        }
        return $this->render('Reclamation/Fedit.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/FReclamation/corbeille/{id}",name="Fcorbeille")
     */
    public function Fcorbeille(Request $request, $id) {
        $entityManager = $this->getDoctrine()->getManager();
        $article = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
        $article->setMsgA('ACORBEILLE');
        $entityManager->persist($article);
        $entityManager->flush();
        return $this->redirectToRoute('FReclamation');}


    /**
     * @Route("/FReclamation/restore/{id}",name="Frestore")
     */
    public function Frestaurer(Request $request, $id) {
        $entityManager = $this->getDoctrine()->getManager();
        $article = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
        $article->setMsgA('ABR');
        $entityManager->persist($article);
        $entityManager->flush();
        return $this->redirectToRoute('FRC');}

    /**
     * @Route("/FReclamation/archive/{id}",name="Farchive")
     */
    public function Farchiver(Request $request, $id) {
        $entityManager = $this->getDoctrine()->getManager();
        $article = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
        $article->setMsgA('AARCHIVE');
        $entityManager->persist($article);
        $entityManager->flush();
        return $this->redirectToRoute('FReclamation');}

    /**
     * @Route("/FReclamation/delete/{id}",name="Fdelete_prof")
     */
    public function Fdelete(Request $request, $id) {
        $article = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($article);
        $entityManager->flush();

        $response = new Response();
        $response->send();

        return $this->redirectToRoute('FRC');
    }




}
