<?php

namespace App\Cart\Repository;


use App\Entity\Cart;
use App\Entity\Camera;
use App\Entity\CartItem;
use Symfony\Component\HttpFoundation\RequestStack;

class CartSessionRepository
{
    private $session;
    private $cartSessionKey = 'cart';
   
    public function __construct(RequestStack $requestStack)
    {
        $this->session = $requestStack->getCurrentRequest()->getSession();
    }
    
    public function addItem(Cart $cart,CartItem $cartItem)
    {
        
        $found = false;
        foreach ($cart->getItems() as $item) {
            if ($item->getCamera() === $cartItem->getCamera()) {
                $item->setQuantity($item->getQuantity() + $cartItem->getQuantity());
                $item->setStockage($cartItem->getStockage());
                $item->setPrice($cartItem->getCamera()->getPrix());
                $found = true;
                break;
            }
        }

        $cartItemId = $this->session->get('id', 0);
        if (!$found) {
            $item = new CartItem($cartItem->getCamera(),$cartItem->getQuantity(),$cartItem->getStockage());
            $item->setId(++$cartItemId);
            $item->setPrice($cartItem->getCamera()->getPrix());
            $cart->addItem($item);
            $this->session->set('id', $cartItemId);
        }
    
        $this->saveCart($cart); 
    }
    private function saveCart(Cart $cart): void
    {
        $this->session->set($this->cartSessionKey, $cart);
    }
}