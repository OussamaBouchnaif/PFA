<?php

namespace App\Controller;

use App\Entity\Client;
use App\Factory\Factory;
use App\Forms\ClientType;
use App\Forms\LoginType;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
   
    #[Route('/signup', name: 'app_signup')]
    public function signup(Request $request, ClientRepository $repository,Factory $factory): Response
    {
        $client = $factory->create(Client::class);
        $form = $this->createForm(ClientType::class,$client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $client = $form->getData();
            $repository->addClient($client);
            
            return $this->redirectToRoute('app_test');
        }

        return $this->render('client/pages/signup.html.twig', ['form' => $form]);
    }

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->getUser()) {
             return $this->redirectToRoute('app_test');
         }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
