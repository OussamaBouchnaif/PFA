<?php


namespace App\Cart\Handler;

use App\Cart\Repository\CartSessionRepository;
use App\Entity\Cart;
use App\Entity\Camera;
use Symfony\Component\HttpFoundation\RequestStack;
use \Symfony\Bundle\SecurityBundle\Security;

class CartSessionStorage implements CartStorageInterface
{
    private $session;
    private $cartSessionKey = 'cart';
    private CartSessionRepository $cartSessionRepo;
    private Security $security;
   
    public function __construct(RequestStack $requestStack,CartSessionRepository $cartSessionRepo,Security $security)
    {
        // Récupérer la session actuelle à partir de la pile de requêtes
        $this->session = $requestStack->getCurrentRequest()->getSession();
        $this->cartSessionRepo = $cartSessionRepo;
        $this->security = $security;

        
    }
    
    public function addToCart($item)
    {
        $cart = $this->getCart(); 
        $this->cartSessionRepo->addItem($cart,$item);
    }
   
    public function getCart()
    {
        $cart = $this->session->get($this->cartSessionKey);

        if (!$cart) {
            $cart = new Cart();
            $cart->setClient($this->security->getUser());
            $this->session->set($this->cartSessionKey, $cart);
        }

        return $cart;
    }
    public function updateCart(){

    }
    public function clearCart(){

    }
    private function saveCart(Cart $cart): void
    {
        $this->session->set($this->cartSessionKey, $cart);
    }
}