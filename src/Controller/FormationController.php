<?php

namespace App\Controller;


use App\Entity\Formation;
use App\Entity\Formationapprenant;
use App\Entity\Users;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class FormationController extends AbstractController
{
//Partie administrateur


    /**
     * @param FormationRepository $repo
     * @return Response
     * @Route("/AfficheFormationBack",name="AfficheBack")
     */

    public function AfficheFormationBack(FormationRepository $repo)
    {


        $status="false";

        $formation =$this->getDoctrine()->getRepository(Formation::class)->findBy([
            "status" => "false"
        ]);


        //$formation1= $this->getDoctrine()->getRepository(Formation::class)->find($user);




        return $this->render('Formation/AccepterFormationBack.html.twig', ['formations' => $formation]);

    }

    /**
     * @param $id
     * @param FormationRepository $repo
     * @return Response
     * @Route("/AccepterFormationBack/{id}",name="accepter" , methods={"GET"})
     */
    public function accepterFormation($id,FormationRepository $repo) : Response
    {
        $formation = $this->getDoctrine()->getRepository(Formation::class)->find($id);
        $formation->setStatus("true");

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($formation);
        $entityManager->flush();





        return $this->redirectToRoute('AfficheBack');

    }
    //Partie apprenant
    /**
     * @param $id
     * @return Response
     * @Route("/PDFFormation/{id}",name="PDFbyOneFormation" , methods={"GET"})
     */
    public function PDFbyOne($id) : Response
    {
        $formation = $this->getDoctrine()->getRepository(Formation::class)->find($id);
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('Formation/FormationPDF.html.twig', ['formation' => $formation]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A3', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("Formation.pdf", ["Attachment" => false]);
    }







    /**
     * @param FormationRepository $repo
     * @return Response
     * @Route("/AfficheFormationFront",name="afficherFront")
     */
    public function AfficheFormationFront(FormationRepository $repo)
    {
        $id_apprenant = $this->get('security.token_storage')->getToken()->getUser();


        $user = $this->get('security.token_storage')->getToken()->getUser();
        $formation = $this->getDoctrine()->getRepository(Formation::class)->findBy([
            "status" => "true"
        ]);

        $formation1 = $this->getDoctrine()->getRepository(Formation::class)->findBy([
            "idApprenant" => $user,
            "status" => "true"
        ]);
        //$formation1= $this->getDoctrine()->getRepository(Formation::class)->find($user);




        return $this->render('Formation/AjouterFormationFront.html.twig', ['formations' => $formation, 'formation1' => $formation1]);

    }


    /**
     * @Route("/AjouterFormationFront/{id}", name="ajouterFront")
     * @param $id
     * @param FormationRepository $repo
     * @return Response
     */

    public function AjouterFormationFront($id, FormationRepository $repo): Response
    {
        $id_apprenant = $this->get('security.token_storage')->getToken()->getUser();


        $formation =$this->getDoctrine()->getRepository(Formation::class)->find($id) ;


        $formation->setIdApprenant($id_apprenant);
        $formation->setTest(1);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($formation);
        $entityManager->flush();

        return $this->redirectToRoute('afficherFront');

    }



    /**
     * @Route("/SupprimerFormationFront/{id}", name="supprimerFront")
     * @param $id
     * @param FormationRepository $repo
     * @return Response
     */

    public function SupprimerFormationFront($id, FormationRepository $repo): Response
    {
        $id_apprenant = $this->get('security.token_storage')->getToken()->getUser();



        $formation =$this->getDoctrine()->getRepository(Formation::class)->find($id) ;
        $formation->setStatus("false");

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($formation);
        $entityManager->flush();

        return $this->redirectToRoute('afficherFront');
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
     * @Route("/AfficheJSON", name="Allaff")
     */
    public function Allproducts(NormalizerInterface $Normalizer)
    {

        $repository=$this->getDoctrine()->getRepository(Formation::class);
        $formations= $repository->findAll();

        $jsonContent= $Normalizer->normalize($formations,'json',['groups'=>'post:read']);

        return new Response(json_encode($jsonContent));
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

                // $formation->setIdprof($user);
                /*  $file = $form->get('photo')->getData();

                  $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                  $file->move($this->getParameter('imagedirectory'), $fileName);


                  $formation->setPhoto($fileName);
  */
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




    /*************************JSON AJOUT ********************** */
    /**
     * @Route("/AddformationJSON/new", name="AddformationJSON")
     */

    public function addProdJSON(Request $request, NormalizerInterface $Normalizer){

        $em= $this->getDoctrine()->getManager();
        $formation= new Formation();

        /* $produits->setName($request->get('name'));
         $produits->setImage($request->get('image'));
         $produits->setSubtitle($request->get('subtitle'));
         $produits->setPrix($request->get('prix'));
         $produits->setDescription($request->get('description'));

         /*$produits->setCategory($request->get('category', EntityType::class,
         [
             'class' => Category::class,
             'choice_label' => 'name'
         ]

         ));


         $produits->setLat($request->get('lat'));
         $produits->setLon($request->get('lon'));
 */



        $formation->setIntitule($request->get('intitule'));
        // $formation->setDateDebut($request->get('datedebut'));
        //$formation->setDateFin($request->get('datefin'));
        $formation->setVolumeHoraire($request->get('volumehoraire'));
        $formation->setModeEnseignement($request->get('modeEnseignement'));
        $formation->setLangue($request->get('langue'));



        $em->persist($formation);
        $em->flush();
        $jsonContent= $Normalizer->normalize($formation,'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));;


    }





//*****************************END JSON*********************** */












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






    //*************************JSON UPDATE ********************** */
    /**
     * @Route("/updateformJSON/{id}", name="updateformJSON")
     */

    public function updateProdJSON(Request $request, NormalizerInterface $Normalizer,$id){
        $em= $this->getDoctrine()->getManager();
        $formation= $em->getRepository(Formation::class)->find($id);

        $formation->setIntitule($request->get('intitule'));
        // $formation->setDateDebut($request->get('datedebut'));
        //$formation->setDateFin($request->get('datefin'));
        $formation->setVolumeHoraire($request->get('volumehoraire'));
        $formation->setModeEnseignement($request->get('modeEnseignement'));
        $formation->setLangue($request->get('langue'));


        // $em->persist($produits);
        $em->flush();
        $jsonContent= $Normalizer->normalize($formation,'json',['groups'=>'post:read']);
        return new Response("Information updated successfully".json_encode($jsonContent));;


    }





    //*****************************END JSON*********************** */

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






    //*************************JSON DELETE ********************** */
    /**
     * @Route("/deleteformJSON/{id}", name="deleteformJSON")
     */

    public function deleteProdJSON(Request $request, NormalizerInterface $Normalizer,$id){
        $em= $this->getDoctrine()->getManager();
        $formation= $em->getRepository(Formation::class)->find($id);



        $em->remove($formation);
        $em->flush();
        $jsonContent= $Normalizer->normalize($formation,'json',['groups'=>'post:read']);
        return new Response("Information Deleted successfully".json_encode($jsonContent));;


    }





    //*****************************END JSON*********************** */


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