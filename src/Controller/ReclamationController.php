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

class ReclamationController extends AbstractController
{

    /**
     * @param ReclamationRepository $repo
     * @return Response
     * @Route("/UPDF",name="UPDF")
     */

    public function UPDF(ReclamationRepository $repo): Response
    {
        // Configure Dompdf according to your needs
        $classroom = $repo->findBy(['msg' => 'UBR']);
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
        $dompdf->stream("Reclamation.pdf", ["Attachment" => false]);
    }

    /**
     * @param ReclamationRepository $repo
     * @param \App\Repository\UsersRepository $ru
     * @return Response
     * @Route("/R",name="Reclamation")
     */
    public function Affiche(ReclamationRepository $repo ,UsersRepository $ru): Response
    {   $classroom = $repo->findBy(['msgA' => 'ABR']);

        try {
            $NotifNB = $repo->NotifCount();
        } catch (NoResultException | NonUniqueResultException $e) {}
        return $this->render('Reclamation/Affiche.html.twig', ['articles' => $classroom ,'NotifNB' => $NotifNB]);}


    /**
     * @param ReclamationRepository $repo
     * @return Response
     * @Route("/RC",name="RC")
     */
    public function AfficheRC(Request $request ,ReclamationRepository $repo): Response
    {
      $recl = $repo->findAllRC();
        try {
            $NotifNB = $repo->NotifCount();
        } catch (NoResultException | NonUniqueResultException $e) {}
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
        try {
            $NotifNB = $repo->NotifCount();
        } catch (NoResultException | NonUniqueResultException $e) {}
        return $this->render('Reclamation/AfficheRA.html.twig',["articles" => $recl ,'NotifNB' => $NotifNB]);
    }



    /**
     * @Route("/Messagerie/{id}", name="Messagerie")
     * Method({"GET", "POST"})
     */
    public function Messagerie(Request $request, $id): Response
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
            $new = $form->get('recl')->getData();
            $d = date("Y/m/d h:i:sa"); $r->setExp("ADMIN");
            $r->setRecl($ancien."ADMIN ( $d ) : "."$new"."\n");
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($r);
            $entityManager->flush();
        }
        return $this->render('Reclamation/Messagerie.html.twig', ['form' => $form->createView() ,'alert' => $alert,'recl' => $r]);
    }



    /**
     * @Route("/Reclamation/edit/{id}", name="edit_Reclamation")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id) {
        $article = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
        $msg = $article->getReclmodif(); $article->setRecl("");
        $form = $this->createForm(ReclamationType::class,$article);
        $form->add('Modifier', SubmitType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $d = date("Y/m/d h:i:sa");
            $msg2 = $form->get('recl')->getData(); $msg2 = "ADMIN ( $d ) : ".$msg2;
            $article = $form->getData(); $article->setRecl($msg.$msg2);
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
    {   $classroom = $repo->findBy(['msg' => 'UBR']);

        try {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $idu = $user->getId();
            $NotifNB = $repo->UNotifCount($idu);
        } catch (NoResultException | NonUniqueResultException $e) {}
        return $this->render('Reclamation/FReclamation.html.twig', ['articles' => $classroom ,'NotifNB' => $NotifNB]);}


    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param ReclamationRepository $repo
     * @return Response
     * @Route("/FRC",name="FRC")
     */
    public function FAfficheRC(Request $request ,ReclamationRepository $repo): Response
    {
        $recl = $repo->findAllURC();
        try {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $idu = $user->getId();
            $NotifNB = $repo->UNotifCount($idu);
        } catch (NoResultException | NonUniqueResultException $e) {}
        return $this->render('Reclamation/FAfficheRC.html.twig',['articles' => $recl ,'NotifNB' => $NotifNB]);
    }


    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param ReclamationRepository $repo
     * @return Response
     * @Route("/FRA",name="FRA")
     */
    public function FAfficheRA(Request $request ,ReclamationRepository $repo): Response
    {
        $recl = $repo->findBy(['msg' => 'UARCHIVE']);
        try {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $idu = $user->getId();
            $NotifNB = $repo->UNotifCount($idu);
        } catch (NoResultException | NonUniqueResultException $e) {}
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
            $msg = "USER ( $d ) : ".$new."\n";
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
    public function Fedit(Request $request, $id) {
        $article = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
        $msg = $article->getReclmodif(); $article->setRecl("");
        $form = $this->createForm(FReclamationType::class,$article);
        $form->add('Modifier', SubmitType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $d = date("Y/m/d h:i:sa");
            $msg2 = $form->get('recl')->getData(); $msg2 = "USER ( $d ) : ".$msg2;
            $article = $form->getData(); $article->setRecl($msg.$msg2);
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
    public function Fcorbeille(Request $request, $id): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $article = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
        $article->setMsg('UCORBEILLE');
        $entityManager->persist($article);
        $entityManager->flush();
        return $this->redirectToRoute('FReclamation');}


    /**
     * @Route("/FReclamation/restore/{id}",name="Frestore")
     */
    public function Frestaurer(Request $request, $id): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $article = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
        $article->setMsg('UBR');
        $entityManager->persist($article);
        $entityManager->flush();
        return $this->redirectToRoute('FReclamation');}

    /**
     * @Route("/FReclamation/archive/{id}",name="Farchive")
     */
    public function Farchiver(Request $request, $id): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $article = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
    if($article->getEtat() == "Traité") {
        $article->setMsg('UARCHIVE');
        $entityManager->persist($article);
        $entityManager->flush();
        return $this->redirectToRoute('FReclamation'); }
    /* else { ('bundle flash '); } */   }

    /**
     * @Route("/FReclamation/delete/{id}",name="Fdelete_prof")
     */
    public function Fdelete(Request $request, $id): \Symfony\Component\HttpFoundation\RedirectResponse
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
    public function FMessagerie(Request $request, $id): Response
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
            $new = $form->get('recl')->getData();    $d = date("Y/m/d h:i:sa");
            $uname = $user->getNom();    $r->setExp($uname);
            $r->setRecl($ancien."$uname ( $d ) : "."$new"."\n");
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($r);
            $entityManager->flush();
        }
        return $this->render('Reclamation/FMessagerie.html.twig', ['form' => $form->createView() ,'alert' => $alert,'recl' => $r]);
    }


}
