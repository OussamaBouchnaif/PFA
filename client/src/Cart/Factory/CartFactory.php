<?php

namespace App\Cart\Factory;

use App\Cart\Handler\CartStorageInterface;

class CartFactory 
{

    public function build(CartStorageInterface $cartStorage)
    {

        /*$cart = new Cart();
        $cart->setStatus(CartStatus::placed)
            ->setCreatedAt(new \DateTimeImmutable())
            

        return $cart;*/
    }
}