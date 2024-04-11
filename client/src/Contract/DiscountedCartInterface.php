<?php

declare(strict_types=1);

namespace App\Contract;

/**
 * The contract of a Cart that has a discount.
 */
interface DiscountedCartInterface
{
    /**
     * Get the total amount. If there is a discount, the value is taken into effect.
     *
     * @return float
     */
    public function getTotal(): float;

    /**
     * Gets the value of the discount.
     *
     * @return float
     */
    public function getDiscountValue(): float;

    /**
     * Gets the rate of the discount in percentage.
     *
     * @return float
     */
    public  function getDiscountRate(): float;
}
