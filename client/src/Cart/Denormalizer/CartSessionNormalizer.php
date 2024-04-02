<?php

namespace App\Cart\Denormalizer;



use App\Enum\CartStatus;
use \Symfony\Bundle\SecurityBundle\Security;
use App\Cart\Denormalizer\AbstractCartNormalizer;

class CartSessionNormalizer extends AbstractCartNormalizer
{
    private Security $security;
    public function __construct(Security $security)
    {
        $this->security = $security;
    } 
    public function getCartInfo()
    {
        $cart = $this->cartStorage->getCart();
        return [
            'CreatedAt' => new \DateTimeImmutable(),
            'UpdateAt' => new \DateTimeImmutable(),
            'status' => CartStatus::placed,
            'client' => $this->security->getUser(),
        ];
        return $cart;
    }

    public function getCartLines()
    {
        $cart = $this->cartStorage->getCart();
        $items = $cart->getItems();
        return $items;
    }
}