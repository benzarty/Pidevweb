<?php

namespace App\Controller;


use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormationController extends AbstractController
{


    //Partie apprenant

    /**
     * @param FormationRepository $repo
     * @return Response
     * @Route("/AfficheFormationFront",name="afficherFront")
     */
    public function AfficheFormationFront(FormationRepository $repo)
    {

        $formation = $repo->findAll();
        return $this->render('Formation/AjouterFormationFront.html.twig', ['formations' => $formation]);

    }











    //Partie professeur

    /**
     * @param FormationRepository $repo
     * @return Response
     * @Route("/Affiche",name="afficher")
     */
    public function Affiche(FormationRepository $repo)
    {

        $formation = $repo->findAll();
        return $this->render('Formation/affiche.html.twig', ['formations' => $formation]);
    }





    /**
     * @Route("/Formation/new", name="new_Formation")
     * Method({"GET", "POST"})
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function new(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $formation = new Formation();
        $form = $this->createForm(FormationType::class, $formation);
        $form->add('ajouter', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $formation = $form->getData();
            if($formation->getDateDebut()<$formation->getDateFin()){

                $formation->setIdprof($user);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($formation);
                $entityManager->flush();

                return $this->redirectToRoute('afficher');
            }
            else
            {

                return $this->redirectToRoute('new_Formation');

            }
        }
        return $this->render('Formation/new.html.twig', ['form' => $form->createView()]);
    }


    /**
     * @Route("/Formation/{id}", name="Formation_show")
     * @param $id
     * @return Response
     */
    public function show($id)
    {
        $formation = $this->getDoctrine()->getRepository(Formation::class)->find($id);

        return $this->render('Formation/show.html.twig', array('Formation' => $formation));
    }

    /**
     * @Route("/Formation/edit/{id}", name="edit_Formation")
     * Method({"GET", "POST"})
     * @param Request $request
     * @param $id
     * @return RedirectResponse|Response
     */
    public function edit(Request $request, $id)
    {
        $formation = $this->getDoctrine()->getRepository(Formation::class)->find($id);

        $form = $this->createForm(FormationType::class, $formation);
        $form->add('Modifier', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $formation = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($formation);
            $entityManager->flush();

            return $this->redirectToRoute('afficher');
        }

        return $this->render('Formation/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/Formation/delete/{id}",name="delete_apprenant")
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function delete(Request $request, $id): RedirectResponse
    {
        $formation = $this->getDoctrine()->getRepository(Formation::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($formation);
        $entityManager->flush();

        $response = new Response();
        $response->send();

        return $this->redirectToRoute('afficher');
    }

}
