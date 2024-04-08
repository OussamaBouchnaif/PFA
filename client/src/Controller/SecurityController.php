<?php

namespace App\Controller;

use App\Entity\Client;
use App\Factory\Factory;
use App\Forms\LoginType;
use App\Forms\ClientType;
use App\Repository\ClientRepository;
use App\Cart\Handler\CartStorageInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    private CartStorageInterface $cartStorage;

    public function __construct(CartStorageInterface $cartStorage)
    {
        $this->cartStorage = $cartStorage;
    }
    
    #[Route('/signup', name: 'app_signup')]
    public function signup(Request $request, ClientRepository $repository): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class,$client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $client = $form->getData();
            $repository->addClient($client);
            
            return $this->redirectToRoute('app_home');
        }

        return $this->render('client/pages/signup.html.twig', [
            'form' => $form,
            'cart'=> $this->cartStorage->getCart(),
            'totalItems'=>$this->cartStorage->TotalPriceItems(),
        ]);
    }

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->getUser()) {
             return $this->redirectToRoute('app_home');
         }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername, 
            'error' => $error,
            'cart'=> $this->cartStorage->getCart(),
            'totalItems'=>$this->cartStorage->TotalPriceItems(),
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
