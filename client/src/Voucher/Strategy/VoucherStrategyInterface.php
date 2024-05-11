<?php

declare(strict_types=1);

namespace App\Voucher\Strategy;

use App\Contract\DiscountModelInterface;

interface VoucherStrategyInterface
{
    /**
     * Returns a Voucher Model.
     */
    public function findVoucherModel(?string $voucherIdentifier): ?DiscountModelInterface;

    /**
     * Loads an instance based on the voucher identifier.
     */
    public function loadVoucher(?string $voucherIdentifier): mixed;
}
