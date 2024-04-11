<?php

namespace App\Contract;

/**
 * The contract of a Voucher.
 */
interface VoucherModelInterface
{
    public function getDiscount(): float;

    public function getRate(): float;
}
