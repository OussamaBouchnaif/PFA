<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    public function index(): Response
    {
        return $this->render('client/pages/blog/blog.html.twig', [
            
        ]);
    }

    #[Route('/blog/details', name: 'blog_details')]
    public function details(): Response
    {
        return $this->render('client/pages/blog/blog_details.html.twig', [
            
        ]);
    }
}
