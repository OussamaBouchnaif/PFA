<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Form\BlogType;
use App\Repository\BlogRepository;
use App\Services\BlogModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog_index', methods: ['GET'])]
    public function index(BlogRepository $blogRepository): Response
    {
        $blogs = $blogRepository->findAll();

        return $this->render('blog/show.html.twig', [
            'blogs' => $blogs,
        ]);
    }

    #[Route('/blog/new', name: 'app_blog_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BlogModel $blogModel): Response
    {
        $blog = new Blog();
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser(); // Assuming you have user authentication
            $url = $blogModel->addBlog($blog, $user);

            return $this->redirect($url);
        }

        return $this->render('blog/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }



    #[Route('/blog/{id}/edit', name: 'app_blog_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Blog $blog, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success','Le blog a été modifiée avec succès.');
    
            return $this->redirectToRoute('app_blog_index', ['id' => $blog->getId()]);
        }
    
        return $this->render('blog/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    


    #[Route('/blog/delete/{id}', name: 'app_blog_delete', methods: ['POST', 'DELETE'])]
    public function delete(Blog $blog,EntityManagerInterface $entityManager,BlogRepository $blogRepository,$id): JsonResponse
    {
        $blog = $blogRepository->find($id);
        if (!$blog) {   
            return new JsonResponse(['success' => false, 'message' => 'Reduction not found'], Response::HTTP_NOT_FOUND);
    }
    $entityManager->remove($blog);
    $entityManager->flush();
    return new JsonResponse(['success' => true, 'message' => 'Reduction deleted successfully']);

        }
        
}