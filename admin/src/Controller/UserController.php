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
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> d75b8ee (manage users using a dedicated service UserManager)
    public function __construct(private readonly UserManager $manager)
    {
    }

    #[Route('/user/show', name: 'users_index')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

<<<<<<< HEAD
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }
=======
    #[Route('/users', name: 'users_index')]
=======
    #[Route('/user/show', name: 'users_index')]
>>>>>>> 870065d (Add User whith photo and Security)
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
<<<<<<< HEAD
>>>>>>> cb0b655 (add user and detail)

        // Passer les utilisateurs à la vue Twig
=======
>>>>>>> 870065d (Add User whith photo and Security)
=======
>>>>>>> d75b8ee (manage users using a dedicated service UserManager)
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }


    #[Route('/user/create', name: 'user_create')]
<<<<<<< HEAD
<<<<<<< HEAD
    public function addtest(Request $request): Response
=======
    public function addtest(Request $request, EntityManagerInterface $entityManager): Response
>>>>>>> cb0b655 (add user and detail)
=======
    public function addtest(Request $request): Response
>>>>>>> d75b8ee (manage users using a dedicated service UserManager)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
<<<<<<< HEAD
<<<<<<< HEAD
            $this->manager->saveUser($user, true);
=======
            $entityManager->persist($user);
            $entityManager->flush();
>>>>>>> cb0b655 (add user and detail)
=======
            $this->manager->saveUser($user, true);
>>>>>>> d75b8ee (manage users using a dedicated service UserManager)

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
<<<<<<< HEAD
<<<<<<< HEAD
            $this->manager->saveUser($user, false);


            $this->addFlash('success', 'User updated successfully!');

=======
=======
>>>>>>> d75b8ee (manage users using a dedicated service UserManager)
            // Mettre à jour l'utilisateur dans la base de données
            $entityManager->flush();
=======
=======
>>>>>>> c0bc74d (client list probleme fixing)
            $this->manager->saveUser($user, false);

            $this->addFlash('success', 'User updated successfully!');
<<<<<<< HEAD
    
>>>>>>> 779ae00 (edit and add user)
=======

>>>>>>> b42b885 (fixer image user)
            return $this->redirectToRoute('users_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/user/delete/{id}', name: 'user_delete')]
<<<<<<< HEAD
<<<<<<< HEAD
    public function delete(User $user): Response
    {
<<<<<<< HEAD

        $this->manager->removeUser($user);

=======
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
=======
    public function delete(User $user): Response
>>>>>>> d75b8ee (manage users using a dedicated service UserManager)
    {
<<<<<<< HEAD
        // Supprimer l'utilisateur de la base de données
        $entityManager->remove($user);
        $entityManager->flush();
<<<<<<< HEAD
<<<<<<< HEAD
    
>>>>>>> 779ae00 (edit and add user)
=======
=======
=======
        $this->manager->removeUser($user);
>>>>>>> 8a2524e (manage users using a dedicated service UserManager)
>>>>>>> d75b8ee (manage users using a dedicated service UserManager)
=======
        $this->manager->removeUser($user);
>>>>>>> c0bc74d (client list probleme fixing)

>>>>>>> b42b885 (fixer image user)
        return $this->redirectToRoute('users_index');
    }
}
