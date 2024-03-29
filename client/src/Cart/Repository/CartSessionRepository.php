<?php

namespace App\Cart\Repository;


use App\Entity\Cart;
use App\Entity\Camera;
use App\Entity\CartItem;
use Symfony\Component\HttpFoundation\RequestStack;

class CartSessionRepository
{

    private $cartSessionKey = 'cart';
   
    public function __construct(private readonly RequestStack $request)
    {

    }
    
    public function addItem(Cart $cart,CartItem $cartItem)
    {
        $session = $this->request->getSession();
        $found = false;
        foreach ($cart->getItems() as $item) {
            if ($item->getCamera()->getId() === $cartItem->getCamera()->getId()) {
                $item->setQuantity($item->getQuantity() + $cartItem->getQuantity());
                $item->setStockage($cartItem->getStockage());
                $item->setPrice($cartItem->getCamera()->getPrix());
                $found = true;
                break;
            }
        }

        $cartItemId = $session->get('id', 0);
        if (!$found) {
            $item = new CartItem($cartItem->getCamera(),$cartItem->getQuantity(),$cartItem->getStockage());
            $item->setId(++$cartItemId);
            $item->setPrice($cartItem->getCamera()->getPrix());
            $cart->addItem($item);
            $session->set('id', $cartItemId);
        }

    }
    private function saveCart(Cart $cart): void
    {
        $session = $this->request->getSession();
        $session->set($this->cartSessionKey, $cart);
    }

    public function removeItem(Cart $cart,int $iditem)
    {
        $items = $cart->getItems();

        foreach ($items as $index => $item) {
            if ($item->getId() == $iditem) { 
                unset($items[$index]);
                break; 
            }
        }
        $cart->setItems($items);
    }
}