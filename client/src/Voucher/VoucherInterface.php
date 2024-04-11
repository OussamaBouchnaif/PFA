<?php

namespace App\Voucher;

use App\Contract\DiscountedCartInterface;
use App\Contract\VoucherModelInterface;
use App\Entity\Cart;

interface VoucherInterface
{
    /**
     * Creates a new voucher and stores it in a storage.
     * Return a boolean indicating the state of the voucher storing: true if everything went well, false otherwise.
     *
     * @param string $voucherIdentifier
     *
     * @return bool
     */
    public function placeNewVoucher(string $voucherIdentifier): bool;

    /**
     * Applies the voucher code to the Cart instance.
     *
     * @param string $voucherCode
     * @param Cart $object
     *
     * @return DiscountedCartInterface
     */
    public function applyVoucher(string $voucherCode, Cart $object): DiscountedCartInterface;

    /**
     * Checks if the current voucher code is already applied to the current Cart instance.
     *
     * @param ?string $voucherCode
     * @param Cart $cart
     *
     * @return bool
     */
    public function isAlreadyApplied(?string $voucherCode, Cart $cart): bool;

    /**
     * Gets the voucher identifier. If none, returns null.
     *
     * @return string|null
     */
    public function getVoucherIdentifier(): ?string;

    /**
     * Get the discounted cart instance based on a cart instance and a voucher model instance.
     *
     * @param Cart $object
     * @param VoucherModelInterface|null $voucherInstance
     *
     * @return DiscountedCartInterface
     */
    public function getDiscountedCart(Cart $object, ?VoucherModelInterface $voucherInstance): DiscountedCartInterface;

    /**
     * Invalidates the voucher. Returns true when everything went well, false otherwise.
     *
     * @param string|null $voucherIdentifier
     *
     * @return bool
     */
    public function invalidateVoucher(?string $voucherIdentifier): bool;
}
