<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ChangePasswordController extends AbstractController
{

    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    } 
    
    /**
     * @Route("/compte/change-password", name="change_password")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = $this->getUser();
        $form=$this->createForm(ChangePasswordType::class,$user);
        $form->handleRequest($request);
        $notification=null;
        if ($form->isSubmitted() && $form->isValid()) {
            $old_pwd=$form->get('old_password')->getData();
            if($encoder->isPasswordValid($user,$old_pwd)){
                $new_pwd=$form->get('new_password')->getData();
                $password=$encoder->encodePassword($user,$new_pwd);
                $user->setPassword($password);
                $this->entityManager->flush();
                $notification='votre mot de passe à été modifié';
            }
            else{
                $notification='mot de passe actuelle est incorrecte'; 
            }
            
           
        }
        
        return $this->render('compte/changepassword.html.twig',[
            'form' => $form->createView(),
            'notification'=>$notification

        ]); 

    }
}


