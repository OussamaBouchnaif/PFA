<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ClientType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    #[Route('/signup', name: 'app_signup')]
    public function signup(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        // Créez une nouvelle instance de l'entité User
        $user = new User();

        // Créez le formulaire en utilisant la classe ClientType et l'objet User
        $form = $this->createForm(ClientType::class, $user);

        // Gérez la requête
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encodez le mot de passe
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $user->getPassword() // Utilisez la méthode getPassword() pour récupérer le mot de passe depuis l'objet User
                )
            );

            // Enregistrez l'utilisateur dans la base de données
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // Redirigez l'utilisateur vers la page de connexion après un enregistrement réussi
            return $this->redirectToRoute('app_login');
        }

        // Affichez le formulaire de création de compte
        return $this->render('security/signup.html.twig', [
            'form' => $form->createView(),
        ]);
    }

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
    public function logout(): void
    {
        // Cette méthode peut rester vide car elle sera interceptée par le pare-feu de sécurité pour la déconnexion de l'utilisateur
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
