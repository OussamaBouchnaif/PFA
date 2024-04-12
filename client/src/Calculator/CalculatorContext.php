<?php

namespace App\Calculator;
use App\ValueObject\CartValueObject;

class CalculatorContext 
{

    public function priceCalculator(CartValueObject $cart, ?int $coupon = null):float
    {
        if(null === $coupon)
        {
            $priceCalculator = new TotalCalculatorWithoutCoupon();
            $total = $priceCalculator->TotalCalculator($cart);
            return $total;
        }
        $priceCalculator = new TotalCalculatorWithCoupon();
        $total = $priceCalculator->TotalCalculator($cart,$coupon);
        return $total;
        
    }
}