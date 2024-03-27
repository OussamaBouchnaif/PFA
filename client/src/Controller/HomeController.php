<?php

namespace App\Controller;

use App\Cart\Handler\CartStorageInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    private CartStorageInterface $cartStorage;

    public function __construct(CartStorageInterface $cartStorage)
    {
        $this->cartStorage = $cartStorage;
    }
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('client/pages/index.html.twig',[
            'cart'=> $this->cartStorage->getCart(),
            'totalItems'=>$this->cartStorage->TotalPriceItems(),
        ]);
    }
}
