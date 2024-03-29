<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Form\FReclamationType;
use App\Form\MessagerieType;
use App\Repository\ReclamationRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Users;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Validator\Constraints\Json;

class ReclamationController extends AbstractController
{

//////--------------------------------------ESPACE JSON USER ----------------------------------------------/////////////////////
    /**
     * @param ReclamationRepository $repo
     * @Route("/RUjson/{id}",name="RUjson")
     */
public function AfficheRUJson(Request $request ,ReclamationRepository $repo, SerializerInterface $serializer)
{
    try {
        $idu = $request->get("id");
        $classroom = $repo->findBy(['msg' => 'UBR' ,'idUser' => $idu]);
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $serializer = new Serializer([$normalizer], [$encoder]);
    $formatted = $serializer->normalize($classroom);
    return new JsonResponse($formatted);
    } catch (NoResultException | NonUniqueResultException $e) {}
}


    /**
     * @param ReclamationRepository $repo
     * @Route("/RUAjson/{id}",name="RUAjson")
     */
    public function AfficheRUAJson(Request $request ,ReclamationRepository $repo, SerializerInterface $serializer): JsonResponse
    {
        try {
            $idu = $request->get("id");
            $recl = $repo->findBy(['msg' => 'UARCHIVE' ,'idUser' => $idu]);
            $encoder = new JsonEncoder();
            $normalizer = new ObjectNormalizer();
            $serializer = new Serializer([$normalizer], [$encoder]);
            $formatted = $serializer->normalize($recl);
            return new JsonResponse($formatted);
        } catch (NoResultException | NonUniqueResultException $e) {}
    }


    /**
     * @param ReclamationRepository $repo
     * @Route("/RUCjson/{id}",name="RUCjson")
     */
    public function AfficheRUCJson(Request $request ,ReclamationRepository $repo, SerializerInterface $serializer): JsonResponse
    {
        try {
            $idu = $request->get("id");
            $recl = $repo->findAllURC($idu);
            $encoder = new JsonEncoder();
            $normalizer = new ObjectNormalizer();
            $serializer = new Serializer([$normalizer], [$encoder]);
            $formatted = $serializer->normalize($recl);
            return new JsonResponse($formatted);
        } catch (NoResultException | NonUniqueResultException $e) {}
    }

    /**
     * @Route("/AddRUJson", name="AddRUJson")
     * @Method("POST")
     */

public function AddRUJson(Request $request)
{
    $r = new Reclamation();
    $new = $request->query->get("recl");
    $d = date("Y/m/d h:i:sa");
    $msg = "USERNAME ( $d ) : ".$new."\n";
    $title = $request->query->get("title");

    $em = $this->getDoctrine()->getManager();
    $r->setRecl($msg);    $r->setExp('USERNAME');    $r->setMsgA('ABR');   $r->setMsg('UBR');
    $r->setDate(new \DateTime());    $r->setIdUser(42); $r->setUN('USERNAME'); $r->setTitle($title);

    $em->persist($r);
    $em->flush();
    $serializer = new Serializer([new ObjectNormalizer()]);
    $formatted = $serializer->normalize($r);
    return new JsonResponse($formatted);
}



 /**
 * @Route("/DeleteRUJson", name="DeleteRUJson")
 * @Method("DELETE")
 */
public function DeleteRUJson(Request $request)
{
    $id = $request->get("id");
    $em = $this->getDoctrine()->getManager();
    $r = $em->getRepository(Reclamation::class)->find($id);
    if ($r != null) {
        $em->remove($r);
        $em->flush();

        $serialize = new Serializer([new ObjectNormalizer()]);
        $formatted = $serialize->normalize("La reclamation a été supprimée avec success.");
        return new JsonResponse($formatted);
    }
    return new JsonResponse("id Reclamation invalide.");
}


    /**
     * @Route("/UpdateRUJson", name="UpdateRUJson")
     * @Method("PUT")
     */
public function UpdateRUJson(Request $request)
{
    $d = date("Y/m/d h:i:sa");
    $em = $this->getDoctrine()->getManager();
    $r = $this->getDoctrine()->getManager()->getRepository(Reclamation::class)->find($request->get("id"));
    $r->setRecl("");
    $r->setNom($request->get("nom"));
    $msg = $request->get("reclmodif");  $msg2 = $request->get("recl");
    $msg2 = "USERNAME ( $d ) : ".$msg2;
    $r->setRecl($msg.$msg2);

    $em->persist($r);
    $em->flush();
    $serializer = new Serializer([new ObjectNormalizer()]);
    $formatted = $serializer->normalize($r);
    return new JsonResponse("Apprenant a ete modifiee avec success.");
}


    /**
     * @Route("/MessagerieRUJson", name="MessagerieRUJson")
     * Method({"GET", "POST"})
     */

public function MessagerieRUJson(Request $request)
{
    $entityManager = $this->getDoctrine()->getManager();
    $id = $request->get("id");
    $r = $this->getDoctrine()->getManager()->getRepository(Reclamation::class)->find($id);

    $rn = new Reclamation();  $ancien = $r->getRecl(); $r->setReclmodif($ancien); $rn->setUN($r->getUN());
    $rn->setTitle($r->getTitle()); $rn->setDate($r->getDate()); $rn->setMsg($r->getMsg()); $rn->setEtat($r->getEtat());
    $rn->setExp($r->getExp());  $rn->setIdUser($r->getIdUser());  $rn->setMsgA($r->getMsgA());

    $new = $request->get("recl");
    $d = date("Y/m/d h:i:sa"); $r->setExp("USERNAME");
    $r->setRecl($ancien."USERNAME ( $d ) : "."$new"."\n");
    $entityManager->persist($r);
    $entityManager->flush();

    $encoder = new JsonEncoder();
    $normalizer = new ObjectNormalizer();
    $serializer = new Serializer([$normalizer], [$encoder]);
    $formatted = $serializer->normalize($r);
    return new JsonResponse($formatted);
}







    /**
     * @Route("/CorbeilleJson",name="CorbeilleJson")
     */
    public function FcorbeilleJSON(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $r = $this->getDoctrine()->getManager()->getRepository(Reclamation::class)->find($request->get("id"));
        $r->setMsg('UCORBEILLE');
        $em->persist($r);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($r);
        return new JsonResponse("La Reclamation a été mis en corbeille ");
    }


    /**
     * @Route("/RestorerJson",name="RestorerJson")
     */
    public function FRestaurerJSON(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $r = $this->getDoctrine()->getManager()->getRepository(Reclamation::class)->find($request->get("id"));
        $r->setMsg('UBR');
        $em->persist($r);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($r);
        return new JsonResponse("La Reclamation a été mis en corbeille ");
    }


    /**
     * @Route("/ArchiverJson",name="ArchiverJson")
     */
    public function FArchiverJSON(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $r = $this->getDoctrine()->getManager()->getRepository(Reclamation::class)->find($request->get("id"));
        $r->setMsg('UARCHIVE');
        $em->persist($r);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($r);
        return new JsonResponse("La Reclamation a été archiver ");
    }



//////--------------------------------------ESPACE ADMIN ----------------------------------------------/////////////////////

    /**
     * @param ReclamationRepository $repo
     * @return Response
     * @Route("/UPDF",name="UPDF")
     */

    public function UPDF(ReclamationRepository $repo): Response
    {
        // Configure Dompdf according to your needs
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $idu = $user->getId();
        $classroom = $repo->findBy(['msg' => 'UBR' ,'idUser' => $idu]);
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('Reclamation/pdf.html.twig', ['title' => "Liste des reclamations ",'articles' => $classroom]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A3', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("Liste Des reclamations.pdf", ["Attachment" => false]);
    }

    /**
     * @param ReclamationRepository $repo
     * @return Response
     * @Route("/PDF",name="PDF")
     */

    public function PDF(ReclamationRepository $repo): Response
    {
        // Configure Dompdf according to your needs
        $classroom = $repo->findBy(['msgA' => 'ABR']);
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('Reclamation/pdf.html.twig', ['title' => "Liste des reclamations ",'articles' => $classroom]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A3', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("Liste Des reclamations.pdf", ["Attachment" => false]);
    }

    /**
     * @param $id
     * @return Response
     * @Route("Reclamation/PDF/{id}",name="PDFbyOne" , methods={"GET"})
     */
    public function PDFbyOne($id) : Response
    {
        $r = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('Reclamation/pdf2.html.twig', ['r' => $r]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A3', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("Reclamation.pdf", ["Attachment" => false]);}


    /**
     * @param ReclamationRepository $repo
     * @return Response
     * @Route("/R",name="Reclamation")
     */
    public function Affiche(ReclamationRepository $repo): Response
    {   $classroom = $repo->findBy(['msgA' => 'ABR']);
        $NotifNB = $repo->NotifCount();
        return $this->render('Reclamation/Affiche.html.twig', ['articles' => $classroom ,'NotifNB' => $NotifNB]);}


    /**
     * @param ReclamationRepository $repo
     * @return Response
     * @Route("/RC",name="RC")
     */
    public function AfficheRC(Request $request ,ReclamationRepository $repo): Response
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
    public function AfficheRA(Request $request ,ReclamationRepository $repo): Response
    {
        $recl = $repo->findBy(['msgA' => 'AARCHIVE']);
        $NotifNB = $repo->NotifCount();
        return $this->render('Reclamation/AfficheRA.html.twig',["articles" => $recl ,'NotifNB' => $NotifNB]);
    }



    /**
     * @Route("/Messagerie/{id}", name="Messagerie")
     * Method({"GET", "POST"})
     */
    public function Messagerie(Request $request, $id ,FlashyNotifier $flashy): Response
    {
        $r = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
        $rn = new Reclamation();  $ancien = $r->getRecl(); $r->setReclmodif($ancien); $rn->setUN($r->getUN());
        $rn->setTitle($r->getTitle()); $rn->setDate($r->getDate()); $rn->setMsg($r->getMsg()); $rn->setEtat($r->getEtat());
        $rn->setExp($r->getExp());  $rn->setIdUser($r->getIdUser());  $rn->setMsgA($r->getMsgA());
        $form = $this->createForm(MessagerieType::class,$rn);
        $form->add('Envoyer', SubmitType::class);
        $form->handleRequest($request); $alert = "";
        if ( $r->getMsgA() == "AARCHIVE")  $alert = "Si Vous allez envoyer un message la reclamation va etre deplacer vers la boite
         de reception !";
        if($form->isSubmitted() && $form->isValid()) {
            if( $r->getMsg() == "UCORBEILLE" ) {
                $flashy->error('L`UTILISATEUR a SUPPRIMER LA RECLAMATION !', 'http://your-awesome-link.com');
                return $this->redirectToRoute('Reclamation');
                }
            else {
                $new = $form->get('recl')->getData();
                $d = date("Y/m/d h:i:sa"); $r->setExp("ADMIN");
                $r->setRecl($ancien."ADMIN ( $d ) : "."$new"."\n");
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($r);
                $entityManager->flush(); }
        }
        return $this->render('Reclamation/Messagerie.html.twig', ['form' => $form->createView() ,'alert' => $alert,'recl' => $r]);
    }



    /**
     * @Route("/Reclamation/edit/{id}", name="edit_Reclamation")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id ,FlashyNotifier $flashy) {
        $article = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
        $msg = $article->getReclmodif(); $article->setRecl("");
        $form = $this->createForm(ReclamationType::class,$article);
        $form->add('Modifier', SubmitType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            if( $article->getExp() <> "ADMIN" ) {
                $flashy->error('AUCUN MESSAGE SAISIE !', 'http://your-awesome-link.com');
                return $this->redirectToRoute('Reclamation'); }
            else {
                $d = date("Y/m/d h:i:sa");
                $msg2 = $form->get('recl')->getData(); $msg2 = "ADMIN ( $d ) : ".$msg2;
                $article = $form->getData(); $article->setRecl($msg.$msg2);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($article);
                $entityManager->flush();
                return $this->redirectToRoute('Reclamation');
            }
        }return $this->render('Reclamation/edit.html.twig', ['form' => $form->createView()]); }


    /**
     * @Route("/Reclamation/corbeille/{id}",name="corbeille")
     */
    public function corbeille(Request $request, $id): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $article = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
        $article->setMsgA('ACORBEILLE');
        $entityManager->persist($article);
        $entityManager->flush();
        return $this->redirectToRoute('Reclamation');}


    /**
     * @Route("/Reclamation/restore/{id}",name="restore")
     */
    public function restaurer(Request $request, $id): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $article = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
        $article->setMsgA('ABR');
        $entityManager->persist($article);
        $entityManager->flush();
        return $this->redirectToRoute('Reclamation');}

    /**
     * @Route("/Reclamation/archive/{id}",name="archive")
     */
    public function archiver(Request $request, $id): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $article = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
        $article->setMsgA('AARCHIVE');
        $entityManager->persist($article);
        $entityManager->flush();
        return $this->redirectToRoute('Reclamation');}

    /**
     * @Route("/Reclamation/delete/{id}",name="delete_prof")
     */
    public function delete(Request $request, $id): \Symfony\Component\HttpFoundation\RedirectResponse
    {
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
    public function FAffiche(ReclamationRepository $repo): Response
    {
        try {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $idu = $user->getId();  $color = "Nouveau Message !";;
            $NotifNB = $repo->UNotifCount($idu);
            $classroom = $repo->findBy(['msg' => 'UBR' ,'idUser' => $idu]);
        } catch (NoResultException | NonUniqueResultException $e) {}
        return $this->render('Reclamation/FReclamation.html.twig', ['articles' => $classroom ,'NotifNB' => $NotifNB]);}


    /**
     * @param ReclamationRepository $repo
     * @return Response
     * @Route("/FRC",name="FRC")
     */
    public function FAfficheRC(Request $request ,ReclamationRepository $repo): Response
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $idu = $user->getId();
        $recl = $repo->findAllURC($idu);
        $NotifNB = $repo->UNotifCount($idu);
        return $this->render('Reclamation/FAfficheRC.html.twig',['articles' => $recl ,'NotifNB' => $NotifNB]);}


    /**
     * @param ReclamationRepository $repo
     * @return Response
     * @Route("/FRA",name="FRA")
     */
    public function FAfficheRA(Request $request ,ReclamationRepository $repo): Response
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $idu = $user->getId();
        $recl = $repo->findAllURC($idu);
        $NotifNB = $repo->UNotifCount($idu);
        $recl = $repo->findBy(['msg' => 'UARCHIVE' ,'idUser' => $idu]);
        return $this->render('Reclamation/FAfficheRA.html.twig', ['articles' => $recl ,'NotifNB' => $NotifNB]);
    }


    /**
     * @Route("/FReclamation/new", name="new_FReclamation")
     * @return Response
     * Method({"GET", "POST"})
     */

    public function Fnew(Request $request): Response
    {
        $r = new Reclamation();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $idu = $user->getId();   $uname = $user->getNom();
        $form = $this->createForm(FReclamationType::class,$r);
        $form->add('ajouter', SubmitType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $r = $form->getData();
            $new = $form->get('recl')->getData();
            $d = date("Y/m/d h:i:sa");
            $msg = "$uname ( $d ) : ".$new."\n";
            $r->setRecl($msg);    $r->setExp($uname);    $r->setMsgA('ABR');   $r->setMsg('UBR');
            $r->setDate(new \DateTime());    $r->setIdUser($idu); $r->setUN($uname);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($r);
            $entityManager->flush();
            return $this->redirectToRoute('FReclamation');
        }
        return $this->render('Reclamation/FNewReclamation.html.twig',['form' => $form->createView()]);
    }


    /**
     * @Route("/FReclamation/edit/{id}", name="edit_FReclamation")
     * Method({"GET", "POST"})
     */
    public function Fedit(Request $request, $id ,FlashyNotifier $flashy) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $uname = $user->getNom();
        $article = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
        $msg = $article->getReclmodif(); $article->setRecl("");
        $form = $this->createForm(FReclamationType::class,$article);
        $form->add('Modifier', SubmitType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            if( $article->getExp() == "ADMIN" ) {
                $flashy->error('AUCUN MESSAGE SAISIE !', 'http://your-awesome-link.com');
                return $this->redirectToRoute('FReclamation');  }
            else {
                $d = date("Y/m/d h:i:sa");
                $msg2 = $form->get('recl')->getData(); $msg2 = "$uname ( $d ) : ".$msg2;
                $article = $form->getData(); $article->setRecl($msg.$msg2);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($article);
                $entityManager->flush();
                return $this->redirectToRoute('FReclamation'); }
        }
        return $this->render('Reclamation/Fedit.html.twig', ['form' => $form->createView()]);
    }



    /**
     * @Route("/FReclamation/corbeille/{id}",name="Fcorbeille")
     */
    public function Fcorbeille(Request $request, $id ,FlashyNotifier $flashy): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $article = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
        $article->setMsg('UCORBEILLE');
        $entityManager->persist($article);
        $entityManager->flush();
        $flashy->primaryDark('RECLAMATION MIS EN CORBEILLE!', 'http://your-awesome-link.com');
        return $this->redirectToRoute('FReclamation');}


    /**
     * @Route("/FReclamation/restore/{id}",name="Frestore")
     */
    public function Frestaurer(Request $request, $id ,FlashyNotifier $flashy): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $article = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
        $article->setMsg('UBR');
        $entityManager->persist($article);
        $entityManager->flush();
        $flashy->primaryDark('RECLAMATION RESTAURÈE', 'http://your-awesome-link.com');
        return $this->redirectToRoute('FReclamation');}

    /**
     * @Route("/FReclamation/archive/{id}",name="Farchive")
     */
    public function Farchiver(Request $request, $id ,FlashyNotifier $flashy)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $article = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
        $article->setMsg('UARCHIVE');
        $entityManager->persist($article);
        $entityManager->flush();
        $flashy->primaryDark('RECLAMATION ARCHIVER', 'http://your-awesome-link.com');
        return $this->redirectToRoute('FReclamation');
    }

    /**
     * @Route("/FReclamation/delete/{id}",name="Fdelete_prof")
     */
    public function Fdelete(Request $request, $id)
    {
        $article = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($article);
        $entityManager->flush();

        $response = new Response();
        $response->send();

        return $this->redirectToRoute('FRC');
    }


    /**
     * @Route("/FMessagerie/{id}", name="FMessagerie")
     * Method({"GET", "POST"})
     */
    public function FMessagerie(Request $request, $id ,FlashyNotifier $flashy): Response
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $idu = $user->getId();
        $r = $this->getDoctrine()->getRepository(Reclamation::class)->find($id); $r->setIdUser($idu);
        $rn = new Reclamation();  $ancien = $r->getRecl(); $r->setReclmodif($ancien); $rn->setUN($r->getUN());
        $rn->setTitle($r->getTitle()); $rn->setDate($r->getDate()); $rn->setMsg($r->getMsg()); $rn->setEtat($r->getEtat());
        $rn->setExp($r->getExp());  $rn->setIdUser($r->getIdUser());  $rn->setMsgA($r->getMsgA());
        $form = $this->createForm(MessagerieType::class,$rn);
        $form->add('Envoyer', SubmitType::class);
        $form->handleRequest($request); $alert = "";
        if ( $r->getMsg() == "UARCHIVE")  $alert = "Si Vous allez envoyer un message la reclamation va etre deplacer vers la boite
         de reception !";

        if($form->isSubmitted() && $form->isValid()) {
            if( $r->getMsgA() == "ACORBEILLE" ) {
                $flashy->error('L`ADMIN A SUPPRIMER LA RECLAMATION !', 'http://your-awesome-link.com');
                return $this->redirectToRoute('FReclamation'); }
            else {
                $new = $form->get('recl')->getData();    $d = date("Y/m/d h:i:sa");
                $uname = $user->getNom();    $r->setExp($uname);
                $r->setRecl($ancien."$uname ( $d ) : "."$new"."\n");
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($r);
                $entityManager->flush(); }
        }
        return $this->render('Reclamation/FMessagerie.html.twig', ['form' => $form->createView() ,'alert' => $alert,'recl' => $r]);
    }




}
