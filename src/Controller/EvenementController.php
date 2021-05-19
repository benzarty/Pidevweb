<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;


use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/evenement")
 */
class EvenementController extends AbstractController
{
    /**
     * @Route ("/mobile", name="evenement_mobile", methods={"GET","POST"})
     */
    public function affichemobileEvenement(EvenementRepository $evenementRepository, NormalizerInterface $serializer): Response
    {
        $evenement =  $evenementRepository->findAll();
        $json = $serializer->normalize($evenement, 'json');
        return new Response(json_encode($json));

    }
    /**
     * @Route ("/mobileAjouter", name="evenement_mobile_ajouter", methods={"GET","POST"})
     */
    public function mobileEvenementAjouter(Request $request, NormalizerInterface $serializer): Response
    {
        $em = $this->getDoctrine()->getManager();
        $evenement = new Evenement();
        echo "la date est".$request->query->get('date');

        $g = "2018-09-10";
        $reçudate = $request->query->get('date');


        echo "//////////////////\n";
        echo $g;
        echo "//////////////////\n";
        echo $reçudate;
        echo "//////////////////\n";


        echo "le type de g ".gettype($g);
        echo "le type de date ".gettype($request->query->get('date'));

        $evenement->setDateEvenement(\DateTime::createFromFormat('Y-m-d', $reçudate));
        $evenement->setTheme($request->query->get('theme'));
        $evenement->setPresentateur($request->get('presentateur'));
        $evenement->setLien($request->query->get('lien'));
        $evenement->setImage('cf352dbf44943ec822cd8905ed357c9d.jpeg');

        $em->persist($evenement);
        $em->flush();
        $json = $serializer->normalize($evenement, 'json');
        return new Response(json_encode($json));



    }

/////PArtie MOBILE EN HAUT
    /**
     * @Route("/", name="evenement_index", methods={"GET"})
     */
    public function index(EvenementRepository $evenementRepository): Response
    {
        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenementRepository->findAll(),
        ]);
    }

    /*  le methodes pour calendar*/

    /**
     * @Route("/calendar", name="evenement_calendar", methods={"GET"})
     */
    public function calendar(EvenementRepository $evenementRepository): Response
    {

        $event = $evenementRepository->findAll();
        $tableau = [];

        foreach ($event as $events){
            $tableau [] = [
                "id" => $events->getIdEvenement(),
                "lien" => $events->getLien(),
                "image" => $events->getImage(),
                "start" => $events->getDateEvenement()->format('Y-m-d'),
                "presentateur" => $events->getPresentateur(),
                "title" => $events->getTheme()
            ];
        }

        $data = json_encode($tableau);

        return $this->render('evenement/calendar.html.twig', compact('data'));
    }

    /**
     * @Route("/calendar/{id}/update", name="calendar_update", methods={"PUT"})
     */
    public function calendarUpdate(?Evenement $evenement, Request $request): Response
    {
        $donnees = json_decode($request->getContent());
        if(isset($donnees->id) && !empty($donnees->id) &&
            isset($donnees->lien) && !empty($donnees->lien) &&
            isset($donnees->date) && !empty($donnees->date) &&
            isset($donnees->title) && !empty($donnees->title) &&
            isset($donnees->presentateur) && !empty($donnees->presentateur) &&
            isset($donnees->image) && !empty($donnees->image)){
            /*les donner existe*/
            $code = 200;

            if(!$evenement){
                $evenement = new Evenement();
                $code = 201;
            }
            $evenement->setImage($donnees->image);
            $evenement->setLien($donnees->lien);
            $evenement->setTheme($donnees->title);
            $evenement->setPresentateur($donnees->presentateur);
            $evenement->setDateEvenement(new \DateTime($donnees->date));

            $con = $this->getDoctrine()->getManager();
            $con->persist($evenement);
            $con->flush();


            return new Response('donnees reçu', $code);
        }
        else{
            /*les donnees n'existe pas*/
            return new response('donner non reçu',404);
        }

    }


    /* les methodes pour colendar*/

    /**
     * @Route("/affichage", name="evenement_affichage", methods={"GET"})
     */
    public function affichage(Request  $request, EvenementRepository $evenementRepository, PaginatorInterface $paginator): Response
    {

        $donner = $evenementRepository->findAll();
        $evnt = $paginator->paginate($donner, $request->query->getInt('page',1),3);

        return $this->render('evenement/affichage.html.twig', [
            'evenements' => $evnt,
        ]);
    }



    /*testeeeeeeeeeeeeeeeeeeeeee*/

    /**
     * @Route("/affichagefront", name="evenement_affichage_front", methods={"GET"})
     */
    public function affichageFront(EvenementRepository $evenementRepository): Response
    {
        return $this->render('evenement/evenementfront.html.twig');
    }
    /*testeeeeeeeeeeeeeeeeeeeeee*/

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

    /*font*/

    /**
     * @Route("/prochainEvenementF", name="evenement_prochainF", methods={"GET"})
     */
    public function evenementProchainsF(Request  $request, EvenementRepository $evenementRepository, PaginatorInterface $paginator): Response
    {

        $donner = $evenementRepository->evenementProhain();
        $evnt = $paginator->paginate($donner, $request->query->getInt('page',1),3);

        return $this->render('evenement/evenementfront.html.twig', [
            'evenements' => $evnt,
        ]);
    }

    /*public function evenementProchainsF( EvenementRepository $evenementRepository) : Response
    {
        return $this->render('evenement/evenementfront.html.twig', [
            'evenements' => $evenementRepository->evenementProhain(),
        ]);
    }*/

    /**
     * @Route("/evenementDateF/{dat}", name="evenement_dateF", methods={"GET","POST"})
     */
    public function evenementDateF(Request  $request, EvenementRepository $evenementRepository, PaginatorInterface $paginator): Response
    {
        $date = $_GET['dateR'];
        $donner = $evenementRepository->evenementDate('"'.$date.'"');
        $evnt = $paginator->paginate($donner, $request->query->getInt('page',1),3);

        return $this->render('evenement/evenementfront.html.twig', [
            'evenements' => $evnt,
        ]);
    }


    /*public function evenementDateF( EvenementRepository $evenementRepository) : Response
    {

        $date = $_GET['dateR'];

        return $this->render('evenement/evenementfront.html.twig', [
            'evenements' => $evenementRepository->evenementDate('"'.$date.'"'),
        ]);

    }*/

    /**
     * @Route("/semaineF", name="evenement_semaineF", methods={"GET"})
     */
    public function evenementSemaineF(Request  $request, EvenementRepository $evenementRepository, PaginatorInterface $paginator): Response
    {

        $donner = $evenementRepository->evenementSemaine();
        $evnt = $paginator->paginate($donner, $request->query->getInt('page',1),3);

        return $this->render('evenement/evenementfront.html.twig', [
            'evenements' => $evnt,
        ]);
    }

    /*

    public function evenementSemaineF( EvenementRepository $evenementRepository) : Response
    {
        return $this->render('evenement/evenementfront.html.twig', [
            'evenements' => $evenementRepository->evenementSemaine(),
        ]);
    }*/




    /*font*/

    /**
     * @Route("/aujourdhui", name="evenement_aujourdhui", methods={"GET"})
     */

    public function evenementAujourdhui(Request  $request, EvenementRepository $evenementRepository, PaginatorInterface $paginator): Response
    {

        $donner = $evenementRepository->evenementAujourdhui();
        $evnt = $paginator->paginate($donner, $request->query->getInt('page',1),3);

        return $this->render('evenement/evenementfront.html.twig', [
            'evenements' => $evnt,
        ]);
    }


    /*public function evenementAujourdhui( EvenementRepository $evenementRepository) : Response
    {
        return $this->render('evenement/evenementfront.html.twig', [
            'evenements' => $evenementRepository->evenementAujourdhui(),
        ]);
    }*/

    /*font*/


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
