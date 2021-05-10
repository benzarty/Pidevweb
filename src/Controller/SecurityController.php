<?php

namespace App\Controller;

use App\Entity\Administrateur;
use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     * @param Request $request
     * @param AuthenticationUtils $utils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(Request $request, AuthenticationUtils $utils): \Symfony\Component\HttpFoundation\Response
    {

        $error = $utils->getLastAuthenticationError();
        $lastUsername = $utils->getLastUsername();

        return $this->render('security/LoginLogin.html.twig', [
            'error' => $error,
            'last_username' => $lastUsername
        ]);


    }




    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/base", name="base")
     */
    public function back()
    {
        return $this->render('acceuilback.html.twig', [

            $this->getUser()->getUsername()]);

    }


/**
* @Route("/signupJson", name="signupJson")
*/
public function signupJson(Request $request,UserPasswordEncoderInterface $encoder)
{
    $nom = $request->query->get("nom");
    $prenom = $request->query->get("prenom");
    $photo = $request->query->get("photo");
    $email = $request->query->get("email");
    $password = $request->query->get("password");

    $status = $request->query->get("status");
    $role = $request->query->get("role");
    $codesecurity = $request->query->get("codesecurity");

    if(!filter_var($email,FILTER_VALIDATE_EMAIL))
    {
        return new Response("email invalid :/");
    }
    $user=new Users();
    $user->setNom($nom);
    $user->setPrenom($prenom);

    $user->setPhoto($photo);
    $user->setEmail($email);
    $user->setPassword($encoder->encodePassword($user,$password));
    $user->setStatus("false");
    $user->setRole("apprenant");
    $user->setCodesecurity(1);

    try {
        $em=$this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return new JsonResponse("Account is created",200);

    }catch (\Exception $ex)
    {
        return new Response("exception".$ex->getMessage());
    }



}

    /**
     * @Route("/signinJson", name="signinJson")
     */
    public function signinJson(Request $request,UserPasswordEncoderInterface $encoder)
    {
        $email = $request->query->get("email");
        $password = $request->query->get("password");

        $em=$this->getDoctrine()->getManager();
$user=$em->getRepository(Users::class)->findOneBy(['email'=>$email]);

if($user)
{
    if(password_verify($password,$user->getPassword()))
    {
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formated=$serializer->normalize($user);
        return new JsonResponse($formated);

    }
    else{
        return new Response("password invalid");
    }
}
else {
    return new Response("user not found ");
}

    }

    /**
     * @Route("/EditPorfilUserJson", name="EditPorfilUserJson")
     */
    public function EditPorfilUserJson(Request $request,UserPasswordEncoderInterface $encoder)
    {

        $id=$request->get("id");
        $nom = $request->query->get("nom");
        $prenom = $request->query->get("prenom");
        $email = $request->query->get("email");
        $password = $request->query->get("password");
        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository(Users::class)->find($id);


        if($request->files->get("photo") != null)
        {
            $file=$request->files->get("photo");
            $filename=$file->getClientOriginalName();
            $file->move($filename);
            $user->setPhoto($filename);

        }
        $user->setNom($nom);
        $user->setPassword($encoder->encodePassword($user,$password));
        $user->setPrenom($prenom);
        $user->setEmail($email);
        try {
            $em=$this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return new JsonResponse("sucess ",200);

        }catch (\Exception $ex)
        {
            return new Response("failed".$ex->getMessage());
        }

    }




}
