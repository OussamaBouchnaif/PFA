<?php

declare(strict_types=1);

namespace App\Voucher\Strategy;

use App\Contract\VoucherModelInterface;

interface VoucherStrategyInterface
{
    /**
     * Returns a Voucher Model.
     *
     * @param string|null $voucherIdentifier
     *
     * @return VoucherModelInterface|null
     */
    public function findVoucherModel(?string $voucherIdentifier): ?VoucherModelInterface;

    /**
     * Loads an instance based on the voucher identifier.
     *
     * @param string|null $voucherIdentifier
     *
     * @return mixed
     */
    public function loadVoucher(?string $voucherIdentifier): mixed;
}
