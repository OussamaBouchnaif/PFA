<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\User\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function __construct(private readonly UserManager $manager)
    {
    }

    #[Route('/user/show', name: 'users_index')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }


    #[Route('/user/create', name: 'user_create')]
    public function addtest(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->saveUser($user, true);

            $this->addFlash('success', 'User added successfully!');

            return $this->redirectToRoute('users_index'); // Redirection vers la liste des utilisateurs
        }

        return $this->render('user/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/user/edit/{id}', name: 'user_edit')]
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
<<<<<<< HEAD
            // Mettre à jour l'utilisateur dans la base de données
            $entityManager->flush();
=======
            $this->manager->saveUser($user, false);
>>>>>>> 8a2524e (manage users using a dedicated service UserManager)

            $this->addFlash('success', 'User updated successfully!');

            return $this->redirectToRoute('users_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/user/delete/{id}', name: 'user_delete')]
    public function delete(User $user): Response
    {
<<<<<<< HEAD
        // Supprimer l'utilisateur de la base de données
        $entityManager->remove($user);
        $entityManager->flush();
=======
        $this->manager->removeUser($user);
>>>>>>> 8a2524e (manage users using a dedicated service UserManager)

        return $this->redirectToRoute('users_index');
    }
}
