<?php

namespace App\Services;

use App\Entity\Blog;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class BlogModel 
{
    private $entityManager;
    private $urlGenerator;

    public function __construct(EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator)
    {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
    }
    public function getBlogs(){
        $blogs = $this->entityManager->getRepository(Blog::class)->findAll();
        return $blogs;
        
    }

    public function addBlog(Blog $blog, User $user)
    {
        $entityManager = $this->entityManager;

        // Assign the user to the blog
        $blog->setUser($user);

        $entityManager->persist($blog);
        $entityManager->flush();

        // Redirection vers une route nommée 'blog'
        return $this->urlGenerator->generate('blog');
    }

    public function editBlog(Blog $blog)
    {
        $entityManager = $this->entityManager;

        // Persistez les modifications
        $entityManager->persist($blog);
        $entityManager->flush();

        // Redirection vers une route nommée 'blog'
        return $this->urlGenerator->generate('blog');
    }
}
