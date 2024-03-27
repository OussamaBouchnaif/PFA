<?php

namespace App\Controller;

use App\Entity\Camera;
use App\Cart\Handler\CartStorageInterface;
use App\Entity\CartItem;
use App\Forms\CartItemType;
use App\Repository\CameraRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CartController extends AbstractController
{
    private CartStorageInterface $cartStorage;
    private CameraRepository $camRepo;
    public function __construct(CartStorageInterface $cartStorage,CameraRepository $camRepo)
    {
        $this->cartStorage = $cartStorage;
        $this->camRepo = $camRepo;
    }
    #[Route('/cart', name: 'app_cart')]
    public function index(): Response
    {
        $cartData = $this->cartStorage->getCart();
        dd($cartData);
        return $this->render('client/pages/cart/cart.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }
    #[Route('/addToCart',name:'addtocart')]
    public function addToCart(Request $request)
    {
        $quantity = $request->query->get('quantity');
        $idcamera = $request->query->get('idcamera');
        $stockage = $request->query->get('stockage');
        if(!empty($quantity) && !empty($idcamera) && !empty($stockage))
        {
            $camera = $this->camRepo->findOneBy(['id'=> $idcamera]);
            $cartItem = new CartItem($camera,$quantity,$stockage);
            $this->cartStorage->addToCart($cartItem);
            return $this->redirectToRoute('app_cart');
        }
        

    }
    #[Route('/clear',name:'clear')]
    public function clear(Request $request){
        $request->getSession()->remove('cart');
        return $this->redirectToRoute('fetch');

    }

}
