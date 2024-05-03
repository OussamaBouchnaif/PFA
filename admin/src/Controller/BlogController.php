<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Form\BlogType;
use App\Repository\BlogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface; 
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;    
use Symfony\Component\HttpFoundation\JsonResponse;
#[Route('/blog')]
class BlogController extends AbstractController
{
    #[Route('/', name: 'app_blog_index', methods: ['GET'])]
    public function index(BlogRepository $blogRepository): Response
    {
        return $this->render('blog/show.html.twig', [
            'blogs' => $blogRepository->findAll(),
            
        ]);
    }

        #[Route('/new', name: 'app_blog_new', methods: ['GET', 'POST'])]
        public function new(Request $request, EntityManagerInterface $entityManager): Response
        {
            $blog = new Blog();
            $form = $this->createForm(BlogType::class, $blog);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($blog);
                $entityManager->flush();

                return $this->redirectToRoute('app_blog_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('blog/new.html.twig', [
                'form' => $form,
            ]);
        }

    #[Route('/{id}', name: 'app_blog_show', methods: ['GET'])]
    public function show(Blog $blog): Response
    {
        return $this->render('blog/show.html.twig', [
            'blog' => $blog,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_blog_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Blog $blog, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_blog_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('blog/edit.html.twig', [
            'form' => $form,       
            'blog' => $blog,

        ]);
    }

    #[Route('/blog/delete/{id}', name: 'app_blog_delete', methods: ['POST', 'DELETE'])]
    public function deleteBlog(Blog $blog, EntityManagerInterface $entityManager): Response
    {
        // Pas besoin de vérifier si $blog est null, Symfony s'occupera de cela
        
        $entityManager->remove($blog);
        $entityManager->flush();
        
        return new JsonResponse(['success' => true, 'message' => 'Blog deleted successfully']);
    }
    
    
    
}
