<?php

namespace App\Cart\Factory;

use App\Entity\Cart;
use App\Enum\CartStatus;
use App\Cart\Handler\CartStorageInterface;

class CartFactory 
{

    public function build(CartStorageInterface $cartStorage)
    {
        $cart = $cartStorage->getCart();
        $newCart = new Cart();
        $newCart->setStatus(CartStatus::placed)
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdateAt(new \DateTimeImmutable())
            ->setClient($this->getUser());
            
        $this->addItemsToCart($cart,$newCart);
        return $cart;
    }
    public function addItemsToCart(Cart $cart, Cart $newCart)
    {
        $items = $cart->getItems();
        foreach ($items as $item) {
            $newCart->addItem($item);
        }
    }
}