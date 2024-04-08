<?php

namespace App\Cart\Denormalizer;



use App\Enum\CartStatus;
use App\Cart\Handler\CartStorageInterface;
use \Symfony\Bundle\SecurityBundle\Security;
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