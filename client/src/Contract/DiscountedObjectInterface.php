<?php

namespace App\Contract;

interface DiscountedObjectInterface
{
    /**
     * Get the total amount. If there is a discount, the value is taken into effect.
     */
    public function getTotal(): float;

    /**
     * Gets the value of the discount.
     */
    public function getDiscountValue(): float;

    /**
     * Gets the rate of the discount in percentage.
     */
    public function getDiscountRate(): float;

    /**
        * Gets the type of the discount .
     */
    public function getDiscountType():string;
}
