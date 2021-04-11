<?php

namespace App\Controller;

use App\Entity\Apprenant;
use App\Form\ApprenantType;
use App\Repository\ApprenantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApprenantController extends AbstractController
{

    /**
     * @param ApprenantRepository $repo
     * @return Response
     * @Route("/Afficec",name="hahah")
     */
    public function Affiche(ApprenantRepository $repo)
    {

        $classroom = $repo->findAll();
        return $this->render('Apprenant/Affiche.html.twig', ['articles' => $classroom]);
    }


    /**
     * @Route("/Apprenant/new", name="new_apprenant")
     * Method({"GET", "POST"})
     */
    public function new(Request $request)
    {
        $article = new Apprenant();
        $form = $this->createForm(ApprenantType::class, $article);
        $form->add('ajouter', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $request->files->get('post')['my_file'];
            $uploads_directory=$this->getParameter('uploads_directory');
            $filename=md5(uniqid())  .  '.' . $file->guessExtension();

           $file->move($uploads_directory,$filename);
echo "<pre>";
var_dump($file);die;








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
        $article = $this->getDoctrine()->getRepository(Apprenant::class)->find($id);

        return $this->render('Apprenant/show.html.twig', array('article' => $article));
    }

    /**
     * @Route("/Apprenant/edit/{id}", name="edit_apprenant")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id)
    {
        $article = $this->getDoctrine()->getRepository(Apprenant::class)->find($id);

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

        return $this->render('Apprenant/edit.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/Apprenant/delete/{id}",name="delete_apprenant")
     */
    public function delete(Request $request, $id)
    {
        $article = $this->getDoctrine()->getRepository(Apprenant::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($article);
        $entityManager->flush();

        $response = new Response();
        $response->send();

        return $this->redirectToRoute('hahah');
    }

}
