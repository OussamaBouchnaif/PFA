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

    #[Route('/blog/{id}', name: 'app_blog_show', methods: ['GET'])]
    public function show(Blog $blog): Response
    {
        return $this->render('blog/show.html.twig', [
            'blog' => $blog,
        ]);
    }

    #[Route('/blog/{id}/edit', name: 'app_blog_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Blog $blog, BlogModel $blogModel): Response
    {
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $url = $blogModel->editBlog($blog);

            return $this->redirect($url);
        }

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
