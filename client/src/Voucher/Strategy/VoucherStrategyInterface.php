<?php

declare(strict_types=1);

namespace App\Voucher\Strategy;

use App\Contract\VoucherModelInterface;

interface VoucherStrategyInterface
{
    /**
     * Returns a Voucher Model.
     */
    public function findVoucherModel(?string $voucherIdentifier): ?VoucherModelInterface;

    /**
     * Loads an instance based on the voucher identifier.
     */
    public function loadVoucher(?string $voucherIdentifier): mixed;
}
