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

    public function addBlog(Blog $blog, User $user)
    {
        $entityManager = $this->entityManager;

        // Assign the user to the blog
        $blog->setUser($user);

        $entityManager->persist($blog);
        $entityManager->flush();

        // Redirection vers une route nommée 'app_blog_index'
        return $this->urlGenerator->generate('app_blog_index');
    }

    public function editBlog(Blog $blog)
    {
        $entityManager = $this->entityManager;

        // Persistez les modifications
        $entityManager->flush();

        // Redirection vers une route nommée 'app_blog_index'
        return $this->urlGenerator->generate('app_blog_index');
    }

    public function deleteBlog(Blog $blog)
    {
        $entityManager = $this->entityManager;

        // Supprimer le blog
        $entityManager->remove($blog);
        $entityManager->flush();
    }
}
