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
    public function createUser(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->saveUser($user, true);
            $this->addFlash('success', 'User added successfully!');
            return $this->redirectToRoute('users_index');
        }

        return $this->render('user/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/user/edit/{id}', name: 'user_edit')]
    public function editUser(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->saveUser($user, false);

            $this->addFlash('success', 'User updated successfully!');
            return $this->redirectToRoute('users_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/user/delete/{id}', name: 'user_delete')]
    public function deleteUser(User $user): Response
    {

        $this->manager->removeUser($user);
        $this->addFlash('success', 'User deleted successfully!');
        return $this->redirectToRoute('users_index');
    }
}
