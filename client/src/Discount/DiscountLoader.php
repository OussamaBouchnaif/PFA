<?php

declare(strict_types=1);

namespace App\Discount;

use App\Entity\Cart;
use App\Voucher\Strategy\VoucherStrategyInterface;

class DiscountLoader
{
    /**
     * Loads the discount from the database.
     *
     * @param Cart $instance
     * @param string $voucherIdentifier
     * @param VoucherStrategyInterface $strategy
     *
     * @return Cart
     */
    public function loadDiscount(Cart $instance, string $voucherIdentifier, VoucherStrategyInterface $strategy): Cart
    {
        $discount = $strategy->loadVoucher($voucherIdentifier);

        return $instance->setCodePromo($discount);
    }
}
