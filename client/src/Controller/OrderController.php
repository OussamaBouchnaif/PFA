<?php

namespace App\Controller;

use App\Cart\Handler\CartStorageInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_CLIENT')]
class OrderController extends AbstractController
{
    private CartStorageInterface $cartStorage;

    public function __construct(CartStorageInterface $cartStorage)
    {
        $this->cartStorage = $cartStorage;
    }
    
    #[Route('/order', name: 'order')]
    public function check(): Response
    {
        return $this->render('client/pages/checkout.html.twig',[
            'cart'=> $this->cartStorage->getCart(),
            'totalItems'=>$this->cartStorage->TotalPriceItems(),
        ]);
    }
}
