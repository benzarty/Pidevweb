<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/evenement")
 */
class EvenementController extends AbstractController
{
    /**
     * @Route("/", name="evenement_index", methods={"GET"})
     */
    public function index(EvenementRepository $evenementRepository): Response
    {
        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/affichage", name="evenement_affichage", methods={"GET"})
     */
    public function affichage(EvenementRepository $evenementRepository): Response
    {
        return $this->render('evenement/affichage.html.twig', [
            'evenements' => $evenementRepository->findAll(),
        ]);
    }
    /**
     * @Route("/prochainEvenementA", name="evenement_prochain", methods={"GET"})
     */
    public function evenementProchainsA( EvenementRepository $evenementRepository) : Response
    {
        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenementRepository->evenementProhain(),
        ]);
    }

    /**
     * @Route("/evenementDateA/{dat}", name="evenement_date", methods={"GET","POST"})
     */
    public function evenementDateA( EvenementRepository $evenementRepository) : Response
    {

        $date = $_GET['dateR'];

        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenementRepository->evenementDate('"'.$date.'"'),
        ]);

    }

    /**
     * @Route("/semaineA", name="evenement_semaine", methods={"GET"})
     */
    public function evenementSemaineA( EvenementRepository $evenementRepository) : Response
    {
        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenementRepository->evenementSemaine(),
        ]);
    }


    /**
     * @Route("/new", name="evenement_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('image')->getData();

            $fileName= md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('imagedirectory'),$fileName);

            $evenement->setImage($fileName);


            $evenement = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('evenement_index');
        }

        return $this->render('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idEvenement}", name="evenement_show", methods={"GET"})
     */
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }



    /**
     * @Route("/{idEvenement}/edit", name="evenement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Evenement $evenement): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('image')->getData();

            $fileName= md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('imagedirectory'),$fileName);


            $evenement->setImage($fileName);


            $evenement = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('evenement_index');
        }

        return $this->render('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idEvenement}", name="evenement_delete", methods={"POST"})
     */
    public function delete(Request $request, Evenement $evenement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getIdEvenement(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('evenement_index');
    }
}
