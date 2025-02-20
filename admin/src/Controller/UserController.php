<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\User\UserManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

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
    public function addtest(Request $request, UserPasswordHasherInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Hash the password
            $hashedPassword = $passwordEncoder->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);

            // Save the user
            $this->manager->saveUser($user, true);

            $this->addFlash('success', 'User added successfully!');

            return $this->redirectToRoute('users_index'); // Redirection vers la liste des utilisateurs
        }

        return $this->render('user/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/user/edit/{id}', name: 'user_edit')]
    public function edit(Request $request, User $user, UserPasswordHasherInterface $passwordEncoder): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifiez si un nouveau mot de passe a été fourni dans le formulaire
            $newPassword = $form->get('password')->getData();
            if (!empty($newPassword)) {
                // Hash the new password
                $hashedPassword = $passwordEncoder->hashPassword($user, $newPassword);
                $user->setPassword($hashedPassword);
            }

            // Enregistrez les modifications de l'utilisateur
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
public function deleteUser(EntityManagerInterface $entityManager, UserRepository $userRepository, int $id): Response
{
    $user = $userRepository->find($id);

    if (!$user) {
        return new Response(
            json_encode(['success' => false, 'message' => 'User not found']),
            Response::HTTP_NOT_FOUND,
            ['Content-Type' => 'application/json']
        );
    }

    $blogs = $user->getBlogs();

    foreach ($blogs as $blog) {
        $entityManager->remove($blog);
    }

    $entityManager->remove($user);
    $entityManager->flush();

    return new Response(
        json_encode(['success' => true, 'message' => 'User and associated blogs deleted successfully']),
        Response::HTTP_OK,
        ['Content-Type' => 'application/json']
    );
}


}