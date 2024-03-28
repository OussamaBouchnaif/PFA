<?php


namespace App\Cart\Handler;

use App\Cart\Repository\CartSessionRepository;
use App\Entity\Cart;
use App\Entity\Camera;
use App\Entity\CartItem;
use Symfony\Component\HttpFoundation\RequestStack;
use \Symfony\Bundle\SecurityBundle\Security;

class CartSessionStorage implements CartStorageInterface
{
    private $cartSessionKey = 'cart';
    private CartSessionRepository $cartSessionRepo;
    private Security $security;
   
    public function __construct(private readonly RequestStack $request,CartSessionRepository $cartSessionRepo,Security $security)
    {
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
        $session = $this->request->getSession();
        $cart = $session->get($this->cartSessionKey);

        if (!$cart) {
            $cart = new Cart();
            $cart->setClient($this->security->getUser());
            $session->set($this->cartSessionKey, $cart);
        }

        return $cart;
    }
    
    public function TotalPriceItems():float
    {
        $total = 0;
        $items = $this->getCart()->getItems();
        
        foreach($items as $item)
        {
            
            $total += $item->TotalPriceItem();
            
        }
        
        return $total;
    }
    public function removeItem()
    {
        
    }
    public function updateCart(){

    }
    public function clearCart(){

    }

}