<?php

namespace App\Cart\Denormalizer;


use App\Cart\Handler\CartStorageInterface;
use App\Cart\Denormalizer\AbstractCartNormalizer;
use App\ValueObject\CartValueObject;

class CartSessionNormalizer extends AbstractCartNormalizer
{

    public function __construct(CartStorageInterface $cartStorage)
    {
        parent::__construct($cartStorage);
    } 
    public function getCart():CartValueObject
    {
        return $this->cartStorage->getCart();
    }

    
}