<?php

namespace App\Cart\Factory;

use App\Entity\Cart;
use App\Cart\Denormalizer\AbstractCartNormalizer;


class CartFactory 
{
    private AbstractCartNormalizer $normaliser;
    
    public function __construct(AbstractCartNormalizer $normaliser)
    {
        $this->normaliser = $normaliser;
    }

    public function build()
    { 
        $cart = new Cart();
        $cartInfo = $this->normaliser->getCartInfo();
        $cart->setStatus($cartInfo['Status'])
            ->setCreatedAt($cartInfo['CreatedAt'])
            ->setUpdateAt($cartInfo['UpdatedAt'])
            ->setClient($cartInfo['Client'])
            ->setItems($this->normaliser->getCartLines());
        
        return $cart;
    }
    
}