<?php

namespace App\Calculator;

use App\Entity\Cart;use App\Entity\CodePromo;
use App\ValueObject\CartValueObject;

interface TotalCalculatorInterface 
{
    public function TotalCalculator(CartValueObject $cart, ?int $coupon = null): float;
}