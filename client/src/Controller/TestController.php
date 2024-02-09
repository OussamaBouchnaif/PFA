<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Client;
use App\Entity\CodePromo;
use App\Entity\Commande;
use App\Repository\CommandeRepository;
use Symfony\Component\Mercure\Update;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
    #[Route('/', name: 'app_test')]
    public function index(): Response
    {
        return $this->render('client/pages/index.html.twig');
    }
    #[Route('/shop', name: 'shop')]
    public function shop(): Response
    {
        return $this->render('client/pages/shop.html.twig');
    }

    #[Route('/product', name: 'product')]
    public function product(): Response
    {
        return $this->render('client/pages/product-details.html.twig');
    }

    #[Route('/check', name: 'check')]
    public function check(): Response
    {
        return $this->render('client/pages/checkout.html.twig');
    }
    #[Route('/cart', name: 'cart')]
    public function cart(): Response
    {
        return $this->render('client/pages/cart.html.twig');
    }
    #[Route('/blog', name: 'blog')]
    public function blog(): Response
    {
        return $this->render('client/pages/blog.html.twig');
    }
    #[Route('/d', name: 'blogd')]
    public function blogdd(): Response
    {
        return $this->render('client/pages/blog_details.html.twig');
    }


    #[Route('/login', name: 'login')]
    public function dash(): Response
    {
        return $this->render('client/pages/login.html.twig');
    }
  


    
    
    #[Route('/pub', name: 'appt')]
    public function publish(HubInterface $hub): Response
    {
        $update = new Update(
            'https://example.com/books/1',
            json_encode(['status' => 'OutOfStock'])
        );

        $hub->publish($update);

        return new Response('published!');
    }
}
