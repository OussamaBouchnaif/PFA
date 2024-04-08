<?php

namespace App\Calculator;

use App\Entity\Cart;
use App\Entity\CodePromo;
use App\Calculator\TotalCalculatorInterface;
use App\ValueObject\CartValueObject;

class TotalCalculatorWithCoupon implements TotalCalculatorInterface
{
    public function TotalCalculator(CartValueObject $cart, ?int $coupon = null): float
    {
        $total = 0.0;
        foreach ($cart->getLines() as $ligne) {
            $total += $ligne->TotalPriceItem(); 
        }
        $reduction = $total * ($coupon/100);
        return $total - $reduction;
    }
}