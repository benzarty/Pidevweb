<?php

namespace App\Controller;


use App\Entity\Formation;
use App\Entity\Supportcours;
use App\Form\SupportcoursType;
use App\Repository\SupportcoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SupportcoursController extends AbstractController
{
    /**
     * @param SupportcoursRepository $repo
     * @return Response
     * @Route("/Affichesupporttt",name="affichersupportFront")
     */
    public function AffichersupportFront(SupportcoursRepository $repo)
    {

        $support = $repo->findAll();
        return $this->render('supportcours/AjouterSupportFront.html.twig', ['support' => $support]);
    }

    /**
     * @param SupportcoursRepository $repo
     * @return Response
     * @Route("/Affichesupport",name="afficher1")
     */
    public function Affiche(SupportcoursRepository $repo)
    {

        $support = $repo->findAll();
        return $this->render('supportcours/affiche.html.twig', ['support' => $support]);
    }


    /**
     * @Route("/Support/new", name="new_Support")
     * Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function new(Request $request)
    {
        $support = new Supportcours();
        $form = $this->createForm(SupportcoursType::class, $support);
        $form->add('ajouter', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $support = $form->getData();


            /*   // $file = $formation->getPhoto();
                $file = $form->get('photo')->getData();

                $fileName= md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('imagedirectory'),$fileName);


                $formation->setPhoto($fileName);
 */


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($support);
            $entityManager->flush();

            return $this->redirectToRoute('afficher1');
        }


        return $this->render('supportcours/new.html.twig', ['form' => $form->createView()]);
    }


    /**
     * @Route("/Support/{id}", name="Support_show")
     * @param $id
     * @return Response
     */
    public function show($id)
    {
        $support = $this->getDoctrine()->getRepository(Supportcours::class)->find($id);

        return $this->render('supportcours/show.html.twig', array('supportcour' => $support));
    }

    /**
     * @Route("/Support/edit/{id}", name="edit_Support")
     * Method({"GET", "POST"})
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function edit(Request $request, $id)
    {
        $support = $this->getDoctrine()->getRepository(Supportcours::class)->find($id);

        $form = $this->createForm(SupportcoursType::class, $support);
        $form->add('Modifier', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $support = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($support);
            $entityManager->flush();

            return $this->redirectToRoute('afficher1');
        }

        return $this->render('supportcours/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/Support/delete/{id}",name="delete_support")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Request $request, $id): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $support = $this->getDoctrine()->getRepository(Supportcours::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($support);
        $entityManager->flush();

        $response = new Response();
        $response->send();

        return $this->redirectToRoute('afficher1');
    }

}
