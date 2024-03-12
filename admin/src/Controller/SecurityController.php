<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ClientType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SecurityController extends AbstractController
{
    

    #[Route('/login', name: 'app_login')]
    public function login(Request $request, \Symfony\Component\Security\Http\Authentication\AuthenticationUtils $authenticationUtils): Response
    {
        // Récupérez l'erreur de connexion
        $error = $authenticationUtils->getLastAuthenticationError();

        // Récupérez le dernier nom d'utilisateur saisi par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();

        // Affichez le formulaire de connexion
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }


        #[Route('/logout', name: 'app_logout')]
        public function logout(): RedirectResponse
        {
            // Redirecting to the login page
            return $this->redirectToRoute('app_login');
        }

}
