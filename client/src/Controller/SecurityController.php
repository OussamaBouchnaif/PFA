<?php

namespace App\Controller;

use App\Entity\Client;
use App\Forms\LoginType;
use App\Forms\ClientType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;



class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(Request $request,ClientRepository $repo , AuthenticationUtils $authenticationUtils, UserPasswordHasherInterface $passwordEncoder): Response
    {       
        $form = $this->createForm(LoginType::class);
        $form->handleRequest($request);
        $error = null;
        $lastUsername = $authenticationUtils->getLastUsername();
        if($form->isSubmitted())
        {
            
            $email = $form->get('email')->getData();
            $password = $form->get('password')->getData();
            
            if($repo->authenticateClient($email,$password))
            {
                $error = false;
                return $this->redirectToRoute('app_test');
                
            }
            $error = true;  
        }
        return $this->render('client/pages/login.html.twig', [
            'form'=>$form,'last_username' => $lastUsername, 'error' => $error,
        ]);
    }
    #[Route('/signup', name: 'app_signup')]
    public function Signup(Request $request ,ClientRepository $repository): Response
    {   
        $form = $this->createForm(ClientType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->IsValid())
        {
            $client = $form->getData();
            $repository->addClient($client);
            return $this->redirectToRoute("app_test");
        }
        return $this->render('client/pages/signup.html.twig',['form' => $form]);
    }
}
