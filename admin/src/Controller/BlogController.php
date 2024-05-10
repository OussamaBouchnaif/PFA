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
    public function edit(Request $request, Blog $blog, BlogModel $blogModel): Response
    {
        // Create a form based on the BlogType form type
        $form = $this->createForm(BlogType::class, $blog);

        // Handle the request and check if the form is valid
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // If the form is valid, update the blog post and redirect to the index page
            $url = $blogModel->editBlog($blog);

            return $this->redirect($url);
        }

        // Return the form with the blog post data
        return $this->render('blog/edit.html.twig', [
            'form' => $form->createView(),
            'blog' => $blog,
        ]);
    }


    #[Route('/blog/delete/{id}', name: 'app_blog_delete', methods: ['POST', 'DELETE'])]
    public function delete(Blog $blog, BlogModel $blogModel): Response
    {
        $blogModel->deleteBlog($blog);

        return $this->redirectToRoute('app_blog_index');
    }
}
