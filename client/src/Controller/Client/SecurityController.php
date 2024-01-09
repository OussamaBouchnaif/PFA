<?php

namespace App\Controller\Client;

use App\Entity\Client;
use App\Forms\ClientType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(): Response
    {
        return $this->render('client/pages/login.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }
    #[Route('/signup', name: 'app_signup')]
    public function Signup(Request $request,EntityManagerInterface $manager ): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class,$client);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->IsValid())
        {
            $client = $form->getData();
            $client->setPlainPassword($client->getPassword());
            $manager->persist($client);
            $manager->flush();

            return $this->redirectToRoute("app_test");
        }
        return $this->render('client/pages/signup.html.twig',['form' => $form]);
    }
}
