<?php

namespace App\Twig;

use Twig\Extension\GlobalsInterface;
use Twig\Extension\AbstractExtension;
use App\Cart\Handler\CartStorageInterface;

class CartExtension extends AbstractExtension implements GlobalsInterface
{

    public function __construct(private CartStorageInterface $cartStorage)
    {
       
    }
    public function getGlobals(): array
    {
        return [
            'cart' => $this->cartStorage->getCart(),
            'totalItems' => $this->cartStorage->TotalPriceItems(),
        ];
    }

}
