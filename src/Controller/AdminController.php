<?php

namespace App\Controller;

use App\Entity\Administrateur;
use App\Entity\Apprenant;
use App\Entity\Formation;
use App\Entity\Users;
use App\Form\AdminFomType;
use App\Form\ProfesseurType;
use App\Repository\ReclamationRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Egulias\EmailValidator\Validation\RFCValidation;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;

class AdminController extends AbstractController

{
    /**
     * @Route("/stat", name="stati")
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository(Users::class);

        $repository2 = $this->getDoctrine()->getRepository(Formation::class);

        $Users = $repository->findAll();

        $Formations = $repository2->findAll();



        $em = $this->getDoctrine()->getManager();

        $rd = 0;
        $es = 0;



        $engline = 0;
        $presentiel = 0;

        foreach ($Users as $Users) {
            if ($Users->getRole() == 'apprenant')  :

                $rd += 1;
            else :
                $es += 1;

            endif;

        }

        foreach ($Formations as $Formations) {
            if ($Formations->getModeEnseignement() == 'en ligne')  :

                $engline += 1;
            else :
                $presentiel += 1;

            endif;

        }


        $pieChart = new PieChart();

        $pieChart2 = new PieChart();

        $pieChart->getData()->setArrayToDataTable(
            [['Superieur à 2021', 'nombres'],
                ['apprenant', $rd],
                ['professeur', $es]
            ]
        );
        $pieChart->getOptions()->setTitle('Pourcentage Usage sur site');
        $pieChart->getOptions()->setHeight(400);
        $pieChart->getOptions()->setWidth(500);
        $pieChart->getOptions()->setBackgroundColor('#696969');

        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#191970');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);




        $pieChart2->getData()->setArrayToDataTable(
            [['Superieur à 2021', 'nombres'],
                ['en ligne', $engline],
                ['presentiel', $presentiel]
            ]
        );
        $pieChart2->getOptions()->setTitle("Mode D'enseignement");
        $pieChart2->getOptions()->setHeight(400);
        $pieChart2->getOptions()->setWidth(500);
        $pieChart2->getOptions()->setBackgroundColor('#696969');

        $pieChart2->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart2->getOptions()->getTitleTextStyle()->setColor('#191970');
        $pieChart2->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart2->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart2->getOptions()->getTitleTextStyle()->setFontSize(20);






        return $this->render('admin/stat.html.twig', ['piechart' => $pieChart,'piechart2' => $pieChart2]);
    }

    /**
     * @param ReclamationRepository $repo
     * @return Response
     * @Route("/admin", name="admin")
     */
    public function index(ReclamationRepository $repo): Response
    {

        return $this->redirectToRoute('stati');
    }


    /**
     * @Route("/home", name="home")
     */
    public function home(ReclamationRepository $repo, Request $request, AuthenticationUtils $utils): \Symfony\Component\HttpFoundation\Response
    {
        $NotifNB = $repo->NotifCount();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if (($user->getRole() == "apprenant") and ($user->getStatus() == "True"))
            return $this->render('HomeFront/FrontApprenantMain.html.twig');
        else if (($user->getRole() == "apprenant") and ($user->getStatus() == "False") and ($user->getCodesecurity() > 1))
            return $this->render('Apprenant/TestCode.html.twig');

        else if ($user->getRole() == "professeur")
            return $this->redirectToRoute('AfficheEmploiProf');
        else if ($user->getRole() == "admin")
            return $this->redirectToRoute('stati');

        else
            $this->addFlash(
                'info', 'Your have entred wrong Password or your account is blocked Sir or maybe you dont have access  !!');
        return $this->redirectToRoute('login');


    }


    /**
     * @Route("/", name="homee")
     */
    public function FontAllUsers()
    {
        return $this->render('HomeFront/HomeFrontAllUsers.html.twig');

    }

    /**
     * @param UsersRepository $repo
     * @return Response
     * @Route("/Unblock", name="Unblock")
     */
    public function UnblockUsersPage(UsersRepository $repo)
    {


        $classroom = $repo->findBy([
            'status' => 'false']);

        return $this->render('admin/UnblockUser.html.twig', ['articles' => $classroom]);

    }


    /**
     * @Route("/Admin/Unblock/{id}",name="unblockbenz")
     */
    public function unblock(Request $request, $id, \Swift_Mailer $mailer)
    {


        $random = random_int(2, 255);


        $article = $this->getDoctrine()->getRepository(Users::class)->find($id);


        $article->setCodesecurity($random);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        $response = new Response();
        $response->send();


        $user = $this->get('security.token_storage')->getToken()->getUser();


        $message = (new \Swift_Message('Notification Email'))
            ->setFrom('exapmle@gmail.com')
            ->setTo($article->getEmail())
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'admin/registrationMail.html.twig', ['nbr' => $random, 'nom' => $article->getNom(), 'prenom' => $article->getPrenom()]
                ),
                'text/html'
            );

        $mailer->send($message);


        return $this->redirectToRoute('Unblock');
    }

    /**
     * @Route("/SendMail",name="SendMail")
     */

    public function SendMail(\Swift_Mailer $mailer)
    {
        $random = random_int(1, 5000000);

        $message = (new \Swift_Message('Notification Email'))
            ->setFrom('m.benzarti.1996@gmail.com')
            ->setTo('m.benzarti.1996@gmail.com')
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'admin/registrationMail.html.twig', ['name' => $random]
                ),
                'text/html'
            );

        $mailer->send($message);

        return $this->render('admin/testMail.html.twig');
    }


    /**
     * @param UsersRepository $repo
     * @param Request $request
     * @return Response
     * @Route("Code/Unblock", name="search")
     */
    public function Recherchestudent(UsersRepository $repo, Request $request)
    {

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $student = $repo->findOneBy(['codesecurity' => $user->getCodesecurity()]);
        $data2 = $request->get('search2');


        if ($student->getCodesecurity() == $data2) {


            $student->setStatus("True");
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($student);
            $entityManager->flush();
            $this->addFlash(
                'info', 'Your accouted is now Unblocked  !!');

        }
        else
            $this->addFlash(
                'info', 'Your have entred wrong Code  !!');



        return $this->redirectToRoute('home');

    }

    /**
     * @Route("/newAdmin", name="newAdmin")
     * Method({"GET", "POST"})
     */
    public function new(Request $request,UserPasswordEncoderInterface $encoder) {
        $article = new Users();
        $form = $this->createForm(ProfesseurType::class,$article);
        $article->setRole("admin");

        $form->add('ajouter', SubmitType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('photo')->getData();
            $hash=$encoder->encodePassword($article,$article->getPassword());
            $article->setPassword($hash);

            $fileName= md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('imagedirectory'),$fileName);


            $article->setPhoto($fileName);


            $article = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('aficherprof');
        }
        return $this->render('Professeur/NewProf.html.twig',['form' => $form->createView()]);
    }


}
